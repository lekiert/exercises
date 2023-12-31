<?php

declare(strict_types=1);

namespace App\Exercise\Query;

use App\Exercise\Model\Exercise;
use Illuminate\Database\Eloquent\Builder;

class GetExercisesQuery
{
    public function execute(?string $search = null, int $maxResults = 10): Builder
    {
        $query = Exercise::query()
            ->orderByDesc('id')
            ->limit($maxResults);

        if ($search) {
            $query->where('name', 'LIKE', '%' . $search . '%');
        }

        return $query;
    }
}
