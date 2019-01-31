<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnCascadeSummernoteComplaintTextsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('complaint_texts', function (Blueprint $table) {
        //     //
        // });
        DB::statement("ALTER TABLE complaint_texts ADD CONSTRAINT FK_complaint_texts FOREIGN KEY (summernote_id) REFERENCES summernotes(id) ON DELETE CASCADE;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complaint_texts', function (Blueprint $table) {
            //
        });
    }
}
