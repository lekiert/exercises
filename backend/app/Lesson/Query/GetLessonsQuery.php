<?php

declare(strict_types=1);

namespace App\Lesson\Query;

use App\Lesson\Model\Lesson;
use Illuminate\Database\Eloquent\Builder;

class GetLessonsQuery
{
    public function execute(int $maxResults = 10): Builder
    {
        return Lesson::query()
            ->orderByDesc('id');
    }
}
