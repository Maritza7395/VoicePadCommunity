<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComplaintTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complaint_texts', function (Blueprint $table) {
            $table->engine = 'InnoDB';
             $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->integer('summernote_id')->unsigned();
            $table->foreign('summernote_id')->references('id')->on('summernotes');
            $table->integer('motivation_text_id')->unsigned();
            $table->foreign('motivation_text_id')->references('id')->on('motivation_texts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('complaint_texts');
    }
}
