<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::create('employees', function (Blueprint $table) {
                $table->increments('id');
                $table->string('first_name');
                $table->string('middle_name')->nullable();
                $table->string('last_name');
                $table->string('gender');
                $table->string('address');
                $table->boolean('status');
                $table->binary('avatar')->nullable();

                $table->integer('user_id')->unsigned();
                $table->foreign('user_id')->references('id')->on('users');
                $table->integer('company_id')->unsigned();
                $table->foreign('company_id')->references('id')->on('companies');

                $table->timestamps();
            });


        // Schema::table('employees', function (Blueprint $table) {
            
        // });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
