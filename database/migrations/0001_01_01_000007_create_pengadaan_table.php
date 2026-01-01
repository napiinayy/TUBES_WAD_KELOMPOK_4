<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengadaans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_kategori')->constrained('categories')->onDelete('cascade');
            $table->string('nama_barang');
            $table->text('spesifikasi')->nullable();
            $table->foreignId('id_lab')->constrained('labs')->onDelete('cascade');
            $table->integer('jumlah');
            $table->text('alasan_pengadaan');
            $table->string('pengaju')->default('Admin');
            $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengadaans');
    }
};