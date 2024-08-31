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
        Schema::create('account', function (Blueprint $table) {
            $table->increments('account_id');
            $table->string('account_full_name');
            $table->string('account_email_address')->unique();
            $table->string('account_password');
            $table->string('account_role')->default(1)->comment('1 - student, 2 - faculty_member, 3 - admin');
            $table->string('account_matric_number', 10)->nullable()->comment('NULL - not_student');
            // $table->timestamps(); <-- not needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account');
    }
};
