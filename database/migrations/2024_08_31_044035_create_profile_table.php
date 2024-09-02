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
        Schema::create('profile', function (Blueprint $table) {
            $table->increments('profile_id');
            $table->unsignedInteger('account_id');
            $table->foreign('account_id')->references('account_id')->on('account')->onDelete('cascade');
            $table->string('profile_nickname')->nullable();
            $table->string('profile_personal_desc', 1024)->nullable();
            $table->string('profile_enrolment_session', 10)->nullable()->comment('NULL - not_student');
            $table->string('profile_faculty', 8);
            $table->string('profile_course', 128);
            $table->string('profile_picture_filepath', 512)->nullable();
            $table->string('profile_colour_theme', 16)->nullable();
            // $table->timestamps(); <-- not needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profile');
    }
};
