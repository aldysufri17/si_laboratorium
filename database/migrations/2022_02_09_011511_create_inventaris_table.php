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
            $table->string('kode_mutasi', 110);
            $table->string('kode_inventaris', 110)->unique()->nullable();
            $table->integer('masuk')->nullable();
            $table->integer('keluar')->nullable();
            $table->integer('total_mutasi')->nullable();
            $table->integer('total_inventaris');
            $table->string('status', 110);
            $table->string('deskripsi')->nullable();
            $table->string('keterangan')->nullable();
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
