<?php

use App\Exercise\Model\Exercise;
use App\Lesson\Model\Lesson;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lesson_exercises', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(Lesson::class);
            $table->foreignIdFor(Exercise::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_exercises');
    }
};
