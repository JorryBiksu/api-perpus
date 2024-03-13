<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Users extends Migration{
    
    public function up(){
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique();
            $table->text('password');
            $table->string('nama')->nullable();
            $table->string('telp')->nullable();
            $table->string('alamat')->nullable();
            $table->enum('role', ['ADMIN', 'PETUGAS', 'PEMINJAM'])->nullable();
            $table->timestamps();
        });
    }

    public function down(){
        Schema::dropIfExists('users');
    }
}