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
        Schema::create('file_uploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('Student_ID');
            $table->unsignedBigInteger('Topic_ID'); // Match the primary key of `project_topics`
            $table->string('File_Name');
            $table->string('File_Path');
            $table->timestamps();
    
            $table->foreign('Student_ID')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('Topic_ID')->references('id')->on('project_topics')->onDelete('cascade'); // Reference `Topic_ID`
        });
    }
    
    


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_uploads');
    }
};
