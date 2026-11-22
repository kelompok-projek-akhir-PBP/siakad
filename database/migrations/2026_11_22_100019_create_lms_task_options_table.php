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
        Schema::create('lms_task_options', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lms_task_question_id')->constrained('lms_task_questions')->cascadeOnDelete();
            $table->text('option_text');
            $table->boolean('is_correct');
            $table->unsignedSmallInteger('sort_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lms_task_options');
    }
};
