<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnCascadeUserTextFavoritesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('text_favorites', function (Blueprint $table) {
        //     //
        // });
        DB::statement("ALTER TABLE text_favorites ADD CONSTRAINT FK_text_favorites FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('text_favorites', function (Blueprint $table) {
            //
        });
    }
}
