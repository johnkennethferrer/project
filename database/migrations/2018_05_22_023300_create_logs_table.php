<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if (!Schema::hasTable('logs')) {
            # code...
            Schema::create('logs', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('employee_id')->unsigned();
                $table->foreign('employee_id')->references('id')->on('employees');

                $table->dateTime('time_in')->nullable();
                $table->dateTime('time_out')->nullable();
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
