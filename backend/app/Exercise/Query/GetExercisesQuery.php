<?php

declare(strict_types=1);

namespace App\Exercise\Query;

use App\Exercise\Model\Exercise;
use Illuminate\Database\Eloquent\Builder;

class GetExercisesQuery
{
    public function execute(int $maxResults = 10): Builder
    {
        return Exercise::query()
            ->orderByDesc('id')
            ->limit($maxResults);
    }
}
