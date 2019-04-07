<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVacationDatesTable extends Migration
{
    public function up()
    {
        Schema::create('vacation_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->timestamp('leave')->nullable();
            $table->timestamp('back')->nullable();
            $table->integer('accepted')->default(0);
            $table->timestamps();
        });
    }
}
