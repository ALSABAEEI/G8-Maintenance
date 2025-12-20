<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id(); // This creates an unsignedBigInteger 'id' column by default
            $table->string('UserName');
            $table->string('password')->nullable(false);
            $table->string('Email')->nullable();
            $table->string('Role'); // Admin, Supervisor, or Student
            $table->string('Program')->nullable();
            $table->boolean('password_changed')->default(value: false); // Tracks if the user changed their password
            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
