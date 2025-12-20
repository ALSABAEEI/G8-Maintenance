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
    Schema::create('applications', function (Blueprint $table) {
        $table->id(); // Primary key
        $table->foreignId('student_id')->constrained('users')->onDelete('cascade'); // Foreign key to users table
        $table->foreignId('topic_id')->constrained('project_topics')->onDelete('cascade'); // Foreign key to topics table
        $table->string('status')->default('Pending'); // Status of the application
        $table->text('remarks')->nullable(); // Supervisor remarks
        $table->timestamps(); // created_at and updated_at columns
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
