<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCardRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::connection('mysql_read')->create('card_records', function (Blueprint $table) {
            $table->increments('id');
            $table->string('card_uid');
            $table->string('card_gate');
            $table->tinyInteger('direction');
            $table->timestamp('timestamp');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::connection('mysql_read')->dropIfExists('card_records');
    }
}
