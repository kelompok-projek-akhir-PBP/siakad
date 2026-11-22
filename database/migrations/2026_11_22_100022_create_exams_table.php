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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('semester_id')->constrained('semesters')->restrictOnDelete();
            $table->foreignId('subject_id')->constrained('subjects')->restrictOnDelete();
            $table->string('title', 150);
            $table->enum('category', ['UTS', 'UAS', 'LAINNYA']);
            $table->dateTime('open_at');
            $table->dateTime('close_at');
            $table->string('token', 10);
            $table->dateTime('token_updated_at');
            $table->enum('status', ['draf', 'diterbitkan'])->default('draf');
            $table->dateTime('results_announced_at')->nullable();
            $table->foreignId('created_by_user_id')->constrained('users')->restrictOnDelete();
            $table->timestamps();

            $table->index(['semester_id', 'subject_id', 'category'], 'exams_semester_subject_category_index');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
