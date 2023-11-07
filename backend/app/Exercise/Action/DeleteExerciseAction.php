<?php

declare(strict_types=1);

namespace App\Exercise\Action;

use App\Exercise\Model\Exercise;

class DeleteExerciseAction
{
    public function execute(Exercise $exercise): void
    {
        $exercise->delete();
    }
}
