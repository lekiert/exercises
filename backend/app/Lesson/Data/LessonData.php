<?php

declare(strict_types=1);

namespace App\Lesson\Data;

class LessonData
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly ?string $slug,
    ) {
    }
}
