<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Books extends Migration{
    
    public function up(){
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('kategori_id')->unsigned()->default(1);
            $table->string('judul')->nullable();
            $table->string('penulis')->nullable();
            $table->string('penerbit')->nullable();
            $table->string('gambar')->nullable();
            $table->integer('tahun_terbit')->unsigned()->nullable();
            $table->timestamps();
            $table->foreign('kategori_id')->references('id')->on('kategori');
        });
    }

    public function down(){
        Schema::dropIfExists('books');
    }
}