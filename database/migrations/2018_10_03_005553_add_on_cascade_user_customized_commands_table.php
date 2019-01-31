<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnCascadeUserCustomizedCommandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('customized_commans', function (Blueprint $table) {
        //     //
        // });
        DB::statement("ALTER TABLE customized_commands ADD CONSTRAINT FK_customized_commands FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customized_commans', function (Blueprint $table) {
            //
        });
    }
}
