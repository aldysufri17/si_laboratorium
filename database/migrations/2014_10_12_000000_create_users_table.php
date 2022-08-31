<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('role');
            $table->integer('post');
            $table->string('nim', 20)->unique();
            $table->string('name', 110);
            $table->string('email')->unique();
            $table->string('mobile_number', 20)->nullable();
            $table->enum('jk', ['L', 'P']);
            $table->string('alamat');
            $table->string('ktm')->nullable();
            $table->string('foto')->nullable();
            $table->string('password', 60);
            $table->tinyInteger('status')->default(0);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
