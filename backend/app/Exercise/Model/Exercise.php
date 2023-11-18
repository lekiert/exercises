<?php

declare(strict_types=1);

namespace App\Exercise\Model;

use App\Exercise\Enum\ExerciseType;
use Database\Factories\ExerciseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'definition', 'solution', 'type',
    ];

    protected $casts = [
        'definition' => 'array',
        'solution' => 'json',
        'type' => ExerciseType::class,
    ];

    public static function newFactory(): ExerciseFactory
    {
        return new ExerciseFactory;
    }
}
