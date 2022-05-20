<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeminjamanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('kode_peminjaman');
            // $table->text('nama_keranjang');
            $table->integer('user_id');
            $table->integer('barang_id');
            $table->date('tgl_start');
            $table->date('tgl_end');
            $table->integer('jumlah');
            $table->integer('status');
            $table->text('alasan');
            $table->text('kategori_lab');
            $table->text('pesan')->nullable();
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
        Schema::dropIfExists('peminjaman');
    }
}
