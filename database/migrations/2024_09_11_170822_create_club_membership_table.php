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
        Schema::create('club_membership', function (Blueprint $table) {
            $table->unsignedInteger('profile_id');
            $table->foreign('profile_id')->references('profile_id')->on('profile')->onDelete('cascade');
            $table->unsignedInteger('club_id');
            $table->foreign('club_id')->references('club_id')->on('club')->onDelete('cascade');
            $table->primary(['profile_id', 'club_id']);
            $table->integer('membership_type')->default(1)->comment('1 - non_committee, 2 - committee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('club_membership');
    }
};
