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
        Schema::create('class_configurations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('academic_year_id')->constrained('academic_years')->restrictOnDelete();
            $table->foreignId('major_id')->constrained('majors')->restrictOnDelete();
            $table->unsignedTinyInteger('grade_level');
            $table->unsignedTinyInteger('class_count');
            $table->timestamps();

            $table->unique(['academic_year_id', 'major_id', 'grade_level'], 'class_config_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_configurations');
    }
};
