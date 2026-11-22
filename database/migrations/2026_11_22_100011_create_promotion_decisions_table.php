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
        Schema::create('promotion_decisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_enrollment_id')->unique()->constrained('class_enrollments')->restrictOnDelete();
            $table->foreignId('semester_id')->constrained('semesters')->restrictOnDelete();
            $table->enum('system_recommendation', ['direkomendasikan', 'perlu_evaluasi', 'tidak_direkomendasikan']);
            $table->decimal('alpa_percentage', 5, 2);
            $table->enum('final_decision', ['naik_kelas', 'tidak_naik_kelas', 'lulus']);
            $table->foreignId('decided_by_teacher_id')->constrained('teachers')->restrictOnDelete();
            $table->dateTime('decided_at');
            $table->foreignId('corrected_by_user_id')->nullable()->constrained('users')->restrictOnDelete();
            $table->dateTime('corrected_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_decisions');
    }
};
