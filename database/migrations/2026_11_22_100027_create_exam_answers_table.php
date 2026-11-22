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
        Schema::create('exam_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_attempt_id')->constrained('exam_attempts')->cascadeOnDelete();
            $table->foreignId('exam_question_id')->constrained('exam_questions')->restrictOnDelete();
            $table->foreignId('selected_option_id')->nullable()->constrained('exam_question_options')->restrictOnDelete();
            $table->dateTime('answered_at');
            $table->boolean('is_correct')->nullable();
            $table->timestamps();

            $table->unique(['exam_attempt_id', 'exam_question_id'], 'exam_answers_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_answers');
    }
};
