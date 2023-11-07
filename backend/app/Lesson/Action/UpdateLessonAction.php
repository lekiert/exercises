<?php

declare(strict_types=1);

namespace App\Lesson\Action;

use App\Lesson\Data\LessonData;
use App\Lesson\Model\Lesson;
use App\Models\User;
use Illuminate\Support\Str;

class UpdateLessonAction
{
    public function execute(User $user, Lesson $lesson, LessonData $data): Lesson
    {
        $lesson->fill([
            'name' => $data->name,
            'description' => $data->description,
            'slug' => $data->slug ?: $lesson->slug ?: Str::slug($data->name),
        ]);

        $lesson->save();

        return $lesson;
    }
}
