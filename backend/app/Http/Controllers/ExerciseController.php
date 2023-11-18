<?php

namespace App\Http\Controllers;

use App\Exercise\Action\CreateExerciseAction;
use App\Exercise\Action\UpdateExerciseAction;
use App\Exercise\Data\ExerciseData;
use App\Exercise\Enum\ExerciseType;
use App\Exercise\Model\Exercise;
use App\Exercise\Query\GetExercisesQuery;
use App\Http\Requests\StoreExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, GetExercisesQuery $getExercisesQuery)
    {
        $perPage = $request->input('perPage', 25);
        $page = (int)$request->input('page', 1);
        $search = $request->input('q');

        return $getExercisesQuery->execute($search)->paginate($perPage, page: $page);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreExerciseRequest $request, CreateExerciseAction $action): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $data = new ExerciseData(
            $request->input('exercise.name'),
            $request->input('exercise.description'),
            ExerciseType::from($request->input('exercise.type')),
            $request->input('exercise.definition'),
            $request->input('exercise.solution'),
        );

        $exercise = $action->execute($user, $data);

        return response()->json(compact('exercise'));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $exercise = auth()
            ->user()
            ->exercises()
            ->findOrFail($id);

        return response()->json(compact('exercise'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateExerciseRequest $request, int $id, UpdateExerciseAction $action)
    {
        /** @var User $user */
        $user = auth()->user();

        $exercise = auth()
            ->user()
            ->exercises()
            ->findOrFail($id);

        $data = new ExerciseData(
            $request->input('exercise.name'),
            $request->input('exercise.description'),
            $exercise->type,
            $request->input('exercise.definition'),
            $request->input('exercise.solution'),
        );

        $exercise = $action->execute($exercise, $data);

        return response()->json(compact('exercise'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $exercise = auth()
            ->user()
            ->exercises()
            ->findOrFail($id);

        $exercise->delete();

        return response('', 201);
    }

    public function bulkDestroy(Request $request)
    {
        $exercises = auth()
            ->user()
            ->exercises()
            ->whereIn('id', $request->get('ids', []))
            ->get();

        foreach ($exercises as $exercise) {
            $exercise->delete();
        }

        return response('', 201);
    }
}
