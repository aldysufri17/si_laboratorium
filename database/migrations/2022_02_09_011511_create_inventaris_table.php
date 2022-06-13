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
            $table->integer('barang_id');
            $table->text('kode_mutasi');
            $table->text('kode_inventaris')->unique();
            $table->integer('masuk')->nullable();
            $table->integer('keluar')->nullable();
            $table->integer('total_mutasi')->nullable();
            $table->integer('total_inventaris');
            $table->text('status');
            $table->text('deskripsi')->nullable();
            $table->text('keterangan')->nullable();
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
