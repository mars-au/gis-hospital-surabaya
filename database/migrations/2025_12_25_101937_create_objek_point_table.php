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
        Schema::create('objek_point', function (Blueprint $table) {
            $table->id();
            $table->string('nama_objek', 200);
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->decimal('latitude', 10, 8);
            $table->decimal('longitude', 11, 8);
            $table->text('deskripsi')->nullable();
            $table->foreignId('kecamatan_id')->nullable()->constrained('kecamatan')->onDelete('set null');
            $table->string('alamat')->nullable();
            $table->string('telepon', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('objek_point');
    }
};
