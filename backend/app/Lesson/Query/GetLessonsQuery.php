<?php

declare(strict_types=1);

namespace App\Lesson\Query;

use App\Lesson\Model\Lesson;
use Illuminate\Database\Eloquent\Builder;

class GetLessonsQuery
{
    public function execute(?string $search = '', int $maxResults = 10): Builder
    {
        $query = Lesson::query()
            ->orderByDesc('id')
            ->limit($maxResults);

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        return $query;
    }
}
