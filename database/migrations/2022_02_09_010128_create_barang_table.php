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
            $table->text('kode_barang');
            $table->integer('satuan_id');
            $table->integer('kategori_id');
            $table->string('nama');
            $table->integer('stock');
            $table->text('tipe');
            $table->text('kategori_lab')->nullable();
            $table->date('tgl_masuk');
            $table->text('lokasi');
            $table->integer('info');
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
