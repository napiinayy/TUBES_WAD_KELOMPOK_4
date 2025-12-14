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
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_lab']);
            $table->unsignedBigInteger('id_lab')->nullable()->change();
            $table->string('jurusan')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // First set default values for null id_lab
            \DB::table('users')->whereNull('id_lab')->update(['id_lab' => 1]);
            \DB::table('users')->whereNull('jurusan')->update(['jurusan' => 'Unknown']);
            
            $table->unsignedBigInteger('id_lab')->nullable(false)->change();
            $table->string('jurusan')->nullable(false)->change();
            $table->foreign('id_lab')->references('id')->on('labs')->onDelete('cascade');
        });
    }
};
