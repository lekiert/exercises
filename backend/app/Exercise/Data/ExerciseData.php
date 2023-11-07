<?php

declare(strict_types=1);

namespace App\Exercise\Data;

class ExerciseData
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly array $definition,
        public readonly array $solution
    ) {}
}
