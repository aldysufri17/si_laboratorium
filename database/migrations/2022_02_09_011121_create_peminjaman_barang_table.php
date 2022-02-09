<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman_barang', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user');
            $table->integer('id_barang');
            $table->integer('jumlah');
            $table->text('keperluan');
            $table->date('tgl_start');
            $table->date('tgl_end');
            $table->text('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peminjaman_barang');
    }
}
