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
            $table->increments('id');
            $table->string('nama');
            $table->integer('stock');
            $table->text('satuan');
            $table->text('tipe');
            $table->date('tgl_masuk');
            $table->text('lokasi');
            $table->text('info')->nullable();
            $table->integer('rusak')->nullable();
            $table->string('gambar')->nullable();
            $table->enum('show', [0, 1])->default(0);
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
