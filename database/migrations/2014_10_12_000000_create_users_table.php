<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->integer('uid')->unique();
            $table->string('username')->unique();
            $table->string('fullname');
            $table->string('gender');
            $table->string('ic')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->string('address');
            $table->string('position');
            $table->double('salary', 8, 2);
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
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
