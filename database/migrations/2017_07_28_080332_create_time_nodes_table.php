<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimeNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('time_nodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('day');
            $table->integer('hour');
            $table->integer('minute');
            $table->integer('second');
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
        Schema::dropIfExists('time_nodes');
    }
}
