<?php

declare(strict_types=1);

namespace App\Exercise\Data;

use App\Exercise\Enum\ExerciseType;

class ExerciseData
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly ExerciseType $type,
        public readonly array $definition,
        public readonly array $solution
    ) {}
}
