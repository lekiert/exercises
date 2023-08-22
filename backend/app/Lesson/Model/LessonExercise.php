<?php

declare(strict_types=1);

namespace App\Lesson\Model;

use App\Exercise\Model\Exercise;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LessonExercise extends Model
{
    public function exercise(): BelongsTo
    {
        return $this->belongsTo(Exercise::class);
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }
}
