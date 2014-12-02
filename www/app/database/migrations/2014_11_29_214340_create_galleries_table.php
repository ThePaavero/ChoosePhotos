<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGalleriesTable extends Migration
{
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table)
        {
            $table->increments('id');
            $table->string('dir', 32)->index();
            $table->string('token', 30);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('galleries');
    }

}
