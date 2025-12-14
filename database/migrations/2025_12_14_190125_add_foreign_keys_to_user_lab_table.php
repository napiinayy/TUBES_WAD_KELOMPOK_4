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
        Schema::table('user_lab', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('lab_id')->constrained('labs')->onDelete('cascade');
            $table->unique(['user_id', 'lab_id']); // Prevent duplicates
        });
    }

    public function down(): void
    {
        Schema::table('user_lab', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['lab_id']);
            $table->dropUnique(['user_id', 'lab_id']);
        });
    }
};
