<?php

declare(strict_types=1);

namespace App\Exercise\Enum;

enum ExerciseType: string
{
    case BRACKETS = 'brackets';
    case QUIZ = 'quiz';
}
