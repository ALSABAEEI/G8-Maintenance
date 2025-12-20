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
        Schema::create('project_topics', function (Blueprint $table) {
            $table->id(); // This creates an unsignedBigInteger primary key
            $table->unsignedBigInteger('Student_ID')->nullable();
            $table->unsignedBigInteger('Supervisor_ID');
            $table->string('Topic_Title');
            $table->text('Topic_Description');
            $table->string('Status'); // Pending, Approved, Rejected
            $table->timestamps();

            $table->foreign('Student_ID')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('Supervisor_ID')->references('id')->on('users')->onDelete('cascade');
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_topics');
    }
};
