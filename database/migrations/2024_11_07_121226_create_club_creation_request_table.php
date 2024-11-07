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
        Schema::create('club_creation_request', function (Blueprint $table) {
            $table->increments('creation_request_id');
            $table->unsignedInteger('requester_profile_id');
            $table->foreign('requester_profile_id')->references('profile_id')->on('profile');
            $table->string('club_name', 512);
            $table->string('club_category', 16);
            $table->string('club_description', 1024);
            $table->json('club_image_paths')->nullable();
            $table->unsignedInteger('request_status')->comment('-1 - rejected, 0 - pending, 1 - approved, 2 - approved with amendments');
            $table->string('request_remarks', 1024);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_creation_request');
    }
};
