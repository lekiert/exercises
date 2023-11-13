<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Lesson\Action\CreateLessonAction;
use App\Lesson\Action\DeleteLessonAction;
use App\Lesson\Action\UpdateLessonAction;
use App\Lesson\Data\LessonData;
use App\Lesson\Model\Lesson;
use App\Lesson\Model\LessonExercise;
use App\Lesson\Query\GetLessonsQuery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, GetLessonsQuery $getLessonsQuery)
    {
        $perPage = $request->input('perPage', 10);

        return $getLessonsQuery->execute()->paginate($perPage);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request, CreateLessonAction $action)
    {
        $data = new LessonData(
            $request->input('lesson.name'),
            $request->input('lesson.description'),
            $request->input('lesson.slug'),
        );

        $lesson = $action->execute(auth()->user(), $data);

        return response()->json(compact('lesson'));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $lesson = Lesson::query()
            ->with('exercises')
            ->findOrFail($id);

        return response()->json(compact('lesson'));
    }

    public function update(UpdateLessonRequest $request, int $id, UpdateLessonAction $action)
    {
        $data = new LessonData(
            $request->input('lesson.name'),
            $request->input('lesson.description'),
            $request->input('lesson.slug'),
        );

        /** @var Lesson $lesson */
        $lesson = auth()->user()->lessons()->findOrFail($id);

        $lesson = $action->execute(auth()->user(), $lesson, $data);

        $pivotModelIds = [];
        foreach ($request->input('lesson.exercises') as $exercise) {
            $pivotModel = LessonExercise::firstOrNew([
                'lesson_id' => $lesson->id,
                'exercise_id' => $exercise['id']
            ]);

            $pivotModel->save();
            $pivotModelIds[] = $pivotModel->id;
        }

        LessonExercise::query()
            ->where('lesson_id', $lesson->id)
            ->whereNotIn('id', $pivotModelIds)
            ->delete();

        return response()->json(compact('lesson'));
    }

    public function destroy(Lesson $lesson, DeleteLessonAction $action)
    {
        $action->execute($lesson);

        return response(status: 204);
    }
}
