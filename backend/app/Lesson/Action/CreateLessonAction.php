<?php

declare(strict_types=1);

namespace App\Lesson\Action;

use App\Lesson\Data\LessonData;
use App\Lesson\Model\Lesson;
use App\Models\User;
use Illuminate\Support\Str;

class CreateLessonAction
{
    public function execute(User $user, LessonData $data): Lesson
    {
        /** @var Lesson $lesson */
        $lesson = $user->lessons()
            ->create([
                'name' => $data->name,
                'description' => $data->description,
                'slug' => $data->slug ?: Str::slug($data->name),
            ]);

        return $lesson;
    }
}
