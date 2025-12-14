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
        Schema::create('keluhans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('nama_item');
            $table->string('jenis_keluhan');
            $table->text('deskripsi_keluhan');
            $table->string('status')->default('pending');
            $table->string('pelapor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keluhans');
    }
};
