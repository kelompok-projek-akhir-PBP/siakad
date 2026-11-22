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
        Schema::create('lms_task_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lms_task_submission_id')->constrained('lms_task_submissions')->cascadeOnDelete();
            $table->foreignId('lms_task_question_id')->constrained('lms_task_questions')->restrictOnDelete();
            $table->foreignId('selected_option_id')->nullable()->constrained('lms_task_options')->restrictOnDelete();
            $table->boolean('is_correct');
            $table->timestamps();

            $table->unique(['lms_task_submission_id', 'lms_task_question_id'], 'task_answers_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lms_task_answers');
    }
};
