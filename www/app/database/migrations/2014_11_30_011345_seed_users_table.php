<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SeedUsersTable extends Migration
{
    public function up()
    {
        DB::table('users')->insert(
            [
                'email' => 'root@localhost',
                'password' => Hash::make('root'),
                'created_at' => new DateTime,
                'updated_at' => new DateTime
            ]
        );
    }

    public function down()
    {
        DB::table('users')->delete();
    }

}
