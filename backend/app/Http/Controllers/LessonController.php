<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Lesson\Action\CreateLessonAction;
use App\Lesson\Action\DeleteLessonAction;
use App\Lesson\Action\UpdateLessonAction;
use App\Lesson\Data\LessonData;
use App\Lesson\Model\Lesson;
use App\Lesson\Query\GetLessonsQuery;
use App\Models\User;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LessonController extends Controller
{
    private readonly User $user;

    public function __construct(Guard $guard)
    {
        /** @var User $user */
        $user = $guard->user();

        $this->user = $user;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, GetLessonsQuery $getLessonsQuery)
    {
        $perPage = $request->input('perPage', 10);

        return [
            'lessons' => $getLessonsQuery->execute()->paginate($perPage),
        ];
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

        $lesson = $action->execute($this->user, $data);

        return response()->json(compact('lesson'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
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
        $lesson = $this->user->lessons()->findOrFail($id);

        $lesson = $action->execute($this->user, $lesson, $data);

        return response()->json(compact('lesson'));
    }

    public function destroy(Lesson $lesson, DeleteLessonAction $action)
    {
        $action->execute($lesson);

        return response(status: 204);
    }
}
