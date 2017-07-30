<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDailyCheckStatusesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daily_check_status', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id');
            $table->date('date');
            $table->timestamp('am_check')->nullable();
            $table->timestamp('am_away')->nullable();
            $table->timestamp('pm_check')->nullable();
            $table->timestamp('pm_away')->nullable();
            $table->string('status');
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
        Schema::dropIfExists('daily_check_status');
    }
}
