<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id(); // ID Berita
            $table->string('title'); // Judul Berita
            $table->string('author'); // Penulis Berita
            $table->string('description'); // Deskripsi Berita
            $table->text('content'); // Konten Berita
            $table->string('url'); // URL Berita
            $table->string('url_image'); // URL Image Berita
            $table->dateTime('published_at'); // Publish Berita
            $table->string('category'); // Kategori Berita
            $table->timestamps(); // Timestamp
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}
