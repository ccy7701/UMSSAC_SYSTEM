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
        Schema::create('semester_progress_log', function (Blueprint $table) {
            $table->increments('sem_prog_log_id');
            $table->unsignedInteger('profile_id');
            $table->foreign('profile_id')->references('profile_id')->on('profile')->onDelete('cascade');
            $table->unsignedInteger('semester');
            $table->string('academic_session', 12);
            $table->double('semester_gpa', 4, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semester_progress_log');
    }
};
