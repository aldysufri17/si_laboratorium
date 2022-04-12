<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateinventarisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventaris', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('kode_barang');
            $table->text('kode_inventaris');
            $table->integer('masuk')->nullable();
            $table->integer('keluar')->nullable();
            $table->integer('total');
            $table->text('status');
            $table->text('deskripsi')->nullable();
            $table->text('kategori_lab');
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
        Schema::dropIfExists('inventaris');
    }
}
