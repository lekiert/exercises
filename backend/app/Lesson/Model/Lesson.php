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

    public function exercises(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Exercise::class, 'lesson_exercises');
    }

    public static function newFactory(): LessonFactory
    {
        return new LessonFactory;
    }
}
