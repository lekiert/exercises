<?php

namespace App\Exercise\Action;

use App\Exercise\Data\ExerciseData;
use App\Exercise\Model\Exercise;
use App\Lesson\Model\Lesson;

class UpdateExerciseAction
{
    public function execute(Exercise $exercise, ExerciseData $data): Exercise
    {
        $exercise->fill([
            'name' => $data->name,
            'description' => $data->description,
            'type' => $data->type,
            'definition' => $data->definition,
            'solution' => $data->solution,
        ]);

        $exercise->save();

        return $exercise;
    }
}
