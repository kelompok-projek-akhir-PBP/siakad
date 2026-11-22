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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->restrictOnDelete();
            $table->string('nis', 20)->unique();
            $table->string('name', 100);
            $table->enum('gender', ['L', 'P']);
            $table->string('birth_place', 60);
            $table->date('birth_date');
            $table->string('phone', 20)->nullable();
            $table->foreignId('major_id')->constrained('majors')->restrictOnDelete();
            $table->unsignedSmallInteger('entry_year');
            $table->enum('status', ['aktif', 'tidak_aktif', 'lulus'])->default('aktif')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
