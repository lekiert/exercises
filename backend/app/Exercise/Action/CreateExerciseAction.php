<?php

namespace App\Exercise\Action;

use App\Exercise\Data\ExerciseData;
use App\Exercise\Model\Exercise;
use App\Lesson\Model\Lesson;

class CreateExerciseAction
{
    public function execute(Lesson $lesson, ExerciseData $data): Exercise
    {
        /** @var Exercise $exercise */
        $exercise = $lesson->exercises()
            ->create([
                $data->title,
                $data->description,
                $data->definition,
                $data->solution,
            ]);

        return $exercise;
    }
}
