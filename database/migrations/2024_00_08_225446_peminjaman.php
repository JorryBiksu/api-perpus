<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Peminjaman extends Migration{
    
    public function up(){
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('book_id')->unsigned();
            $table->dateTime('tanggal_pinjam');
            $table->dateTime('tanggal_kembali');
            $table->enum('status', ['DIPINJAM', 'KEMBALI', 'HILANG'])->nullable()->default('DIPINJAM');
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('book_id')->references('id')->on('books');
        });
    }

    public function down(){
        Schema::dropIfExists('peminjaman');
    }
}