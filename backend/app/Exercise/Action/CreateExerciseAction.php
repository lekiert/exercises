<?php

namespace App\Exercise\Action;

use App\Exercise\Data\ExerciseData;
use App\Exercise\Model\Exercise;
use App\Lesson\Model\Lesson;
use App\Models\User;

class CreateExerciseAction
{
    public function execute(User $owner, ExerciseData $data): Exercise
    {
        /** @var Exercise $exercise */
        $exercise = $owner->exercises()
            ->create([
                'name' => $data->name,
                'description' => $data->description,
                'type' => $data->type,
                'definition' => $data->definition,
                'solution' => $data->solution,
            ]);

        return $exercise;
    }
}
