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
        if (!Schema::hasColumn('appointments', 'slot_id')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->unsignedBigInteger('slot_id')->nullable(); // Add slot_id column (nullable is optional)
                $table->foreign('slot_id')->references('id')->on('slots')->onDelete('cascade'); // Foreign key
            });
        }
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('appointments', 'slot_id')) {
            Schema::table('appointments', function (Blueprint $table) {
                $table->dropForeign(['slot_id']); // Remove the foreign key constraint
                $table->dropColumn('slot_id');    // Remove the column
            });
        }
    }
};
