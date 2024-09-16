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
        Schema::create('event', function (Blueprint $table) {
            $table->increments('event_id');
            $table->unsignedInteger('club_id');
            $table->foreign('club_id')->references('club_id')->on('club')->onDelete('cascade');
            $table->string('event_name', 255);
            $table->string('event_location', 255);
            $table->datetime('event_datetime');
            $table->string('event_description', 1024);
            $table->double('event_entrance_fee', 8, 2)->nullable();
            $table->boolean('event_sdp_provided')->default(false);
            $table->json('event_image_paths')->nullable();
            $table->string('event_registration_link', 255)->nullable();
            $table->integer('event_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event');
    }
};
