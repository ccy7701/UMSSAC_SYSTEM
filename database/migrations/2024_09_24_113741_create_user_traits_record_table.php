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
        Schema::create('user_traits_record', function (Blueprint $table) {
            $table->increments('user_traits_record_id');
            $table->unsignedInteger('profile_id');
            $table->foreign('profile_id')->references('profile_id')->on('profile')->onDelete('cascade');
            $table->json('wtc_data')->nullable();
            $table->json('personality_data')->nullable();
            $table->json('skills_data')->nullable();
            $table->unsignedInteger('learning_style')->comment('1 - visual, 2 - auditory, 3 - reading/writing, 4 - kinesthetic');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_traits_record');
    }
};
