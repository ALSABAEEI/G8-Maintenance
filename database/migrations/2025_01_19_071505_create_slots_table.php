<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSlotsTable extends Migration
{
    public function up()
    {
        Schema::create('slots', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supervisor_id'); // Supervisor owning the slot
            $table->date('date'); // Slot date
            $table->time('start_time'); // Slot start time
            $table->time('end_time'); // Slot end time
            $table->boolean('available')->default(false); // Whether the slot is available
            $table->timestamps();

            $table->foreign('supervisor_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('slots');
    }
}
