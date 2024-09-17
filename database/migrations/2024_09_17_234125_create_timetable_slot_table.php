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
        Schema::create('timetable_slot', function (Blueprint $table) {
            $table->unsignedInteger('profile_id');
            $table->foreign('profile_id')->references('profile_id')->on('profile')->onDelete('cascade');
            $table->string('class_subject_code', 12);
            $table->string('class_name', 255);
            $table->string('class_category', 12);
            $table->unsignedInteger('class_section');
            $table->string('class_location', 255);
            $table->unsignedInteger('class_day');
            $table->time('class_start_time');
            $table->time('class_end_time');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetable_slot');
    }
};
