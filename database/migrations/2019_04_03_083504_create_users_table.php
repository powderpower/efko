<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->char('first_name', 30)->index();
            $table->char('last_name', 30)->index();
            $table->enum('sex', ['M', 'W'])->default('M');
            $table->timestamps();
        });
    }
}
