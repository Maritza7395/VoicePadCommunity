<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOnCascadeUserComplaintUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('complaint_users', function (Blueprint $table) {
        //     //
        // });
        DB::statement("ALTER TABLE complaint_users ADD CONSTRAINT FK_complaint_users FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complaint_users', function (Blueprint $table) {
            //
        });
    }
}
