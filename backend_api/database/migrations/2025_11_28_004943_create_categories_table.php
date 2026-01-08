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
        Schema::create('categories', function (Blueprint $table) {
            $table->id(); // Kolom ID: Primary Key, Auto-increment, Unsigned Big Integer
            $table->string('name')->unique(); // Kolom Nama: Teks string, harus unik
            $table->text('description')->nullable(); // Kolom Deskripsi: Teks panjang, opsional
            $table->string('slug')->unique(); // Kolom Slug: Biasanya untuk URL yang ramah SEO, harus unik
            $table->timestamps(); // Kolom created_at dan updated_at: Menyimpan waktu pembuatan dan pembaruan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};