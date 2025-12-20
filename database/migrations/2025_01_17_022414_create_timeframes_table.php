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
        Schema::create('timeframes', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('Event_Type'); // Event type (e.g., Choose Topic, Choose Supervisor)
            $table->date('Start_Date');   // Start date of the timeframe
            $table->date('End_Date');     // End date of the timeframe
            $table->string('Semester');  // Semester or session name (e.g., Spring 2025)
            $table->timestamps();        // Created and updated timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timeframes');
    }
};
