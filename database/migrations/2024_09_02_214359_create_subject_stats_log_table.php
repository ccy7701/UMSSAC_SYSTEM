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
        Schema::create('subject_stats_log', function (Blueprint $table) {
            $table->unsignedInteger('sem_prog_log_id');
            $table->foreign('sem_prog_log_id')->references('sem_prog_log_id')->on('semester_progress_log')->onDelete('cascade');
            $table->string('subject_code', 8);
            $table->string('subject_name', 255);
            $table->unsignedInteger('subject_credit_hours');
            $table->string('subject_grade', 2);
            $table->double('subject_grade_point', 4, 2);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_stats_log');
    }
};
