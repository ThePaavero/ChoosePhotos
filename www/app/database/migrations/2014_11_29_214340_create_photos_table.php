<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePhotosTable extends Migration
{
    public function up()
    {
        Schema::create('photos', function ($table)
        {
            $table->increments('id');
            $table->string('hash', 32)->index();
            $table->boolean('accepted')->default(0)->index();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::drop('photos');
    }

}
