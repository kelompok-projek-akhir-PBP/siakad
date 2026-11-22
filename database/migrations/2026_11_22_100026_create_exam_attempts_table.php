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
        Schema::create('exam_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained('exams')->restrictOnDelete();
            $table->foreignId('student_id')->constrained('students')->restrictOnDelete();
            $table->unsignedInteger('shuffle_seed');
            $table->dateTime('started_at');
            $table->dateTime('submitted_at')->nullable();
            $table->enum('submit_type', ['manual', 'otomatis'])->nullable();
            $table->unsignedSmallInteger('correct_count')->nullable();
            $table->unsignedSmallInteger('total_questions')->nullable();
            $table->decimal('score', 5, 2)->nullable();
            $table->boolean('is_locked')->default(false);
            $table->timestamps();

            $table->unique(['exam_id', 'student_id'], 'attempts_exam_student_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exam_attempts');
    }
};
