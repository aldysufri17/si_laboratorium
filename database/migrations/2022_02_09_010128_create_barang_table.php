<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('laboratorium_id');
            $table->integer('satuan_id');
            $table->integer('kategori_id');
            $table->integer('pengadaan_id');
            $table->string('kode_barang', 110);
            $table->string('nama', 110);
            $table->integer('stock');
            $table->string('tipe', 110);
            $table->string('keterangan_rusak')->nullable();
            $table->date('tgl_masuk');
            $table->string('lokasi', 110);
            $table->string('info')->nullable();
            $table->integer('jml_rusak')->nullable();
            $table->string('gambar')->nullable();
            $table->integer('show');
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
        Schema::dropIfExists('barang');
    }
}
