<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRoleIdToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId("role_id")->after("usaha_id")->nullable()->comment("1:admin, 2:user, 3:kasir, 4:acc, 5:etc");
            // $table->foreign("role_id")->references("id")
            //       ->on("users")->onDelete("set null");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // $table->dropForeign("users_role_id_foreign");
            $table->dropColumn("role_id");
        });
    }
}
