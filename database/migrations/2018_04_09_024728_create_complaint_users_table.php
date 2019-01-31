<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint_users', function (Blueprint $table) {
            $table->engine = 'InnoDB';
             $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('user_complaint_id')->unsigned();
            $table->foreign('user_complaint_id')->references('id')->on('users');
            $table->integer('motivation_user_id')->unsigned();
            $table->foreign('motivation_user_id')->references('id')->on('motivation_users'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaint_users');
    }
}
