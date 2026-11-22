<?php

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
        Schema::create('lms_task_submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lms_task_id')->constrained('lms_tasks')->restrictOnDelete();
            $table->foreignId('student_id')->constrained('students')->restrictOnDelete();
            $table->dateTime('submitted_at');
            $table->unsignedSmallInteger('correct_count');
            $table->unsignedSmallInteger('total_questions');
            $table->decimal('score', 5, 2);
            $table->timestamps();

            $table->unique(['lms_task_id', 'student_id'], 'submissions_task_student_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lms_task_submissions');
    }
};
