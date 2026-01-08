<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Kolom ID: Primary Key, Auto-increment
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Kolom Foreign Key ke categories
            $table->string('name'); // Kolom Nama Produk
            $table->text('description')->nullable(); // Kolom Deskripsi: Teks panjang, opsional
            $table->string('slug')->unique(); // Kolom Slug: untuk URL yang ramah SEO, harus unik
            $table->decimal('price', 10, 2); // Kolom Harga: Desimal dengan 10 digit, 2 desimal
            $table->integer('stock')->default(0); // Kolom Stok: Jumlah barang
            $table->string('image')->nullable(); // Kolom Gambar: Path/URL gambar, opsional
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
