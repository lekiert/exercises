<?php

declare(strict_types=1);

namespace App\Lesson\Model;

use App\Exercise\Model\Exercise;
use Database\Factories\LessonFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'slug',
    ];

    public function exercises(): HasManyThrough
    {
        return $this->hasManyThrough(Exercise::class, LessonExercise::class, 'id', 'id', 'lesson_id', 'exercise_id');
    }

    public static function newFactory(): LessonFactory
    {
        return new LessonFactory;
    }
}
