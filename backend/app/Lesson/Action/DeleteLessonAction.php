<?php

declare(strict_types=1);

namespace App\Lesson\Action;

use App\Lesson\Model\Lesson;

class DeleteLessonAction
{
    public function execute(Lesson $lesson): void
    {
        $lesson->delete();
    }
}
