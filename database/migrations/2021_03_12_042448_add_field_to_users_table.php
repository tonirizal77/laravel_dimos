<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique()->after('name');
            $table->string('alamat')->nullable();
            $table->foreignId('cities_id')->nullable();
            $table->foreignId('prov_id')->nullable();
            $table->string('telpon')->nullable();
            // $table->char('tipe',1)->comment('1: Distributor, 2: Store, 3: Customer, 4: Supplier, 5: User');
            $table->string('profilePicture')->nullable();
            $table->boolean('active')->default(true);
            $table->string('relations_id')->nullable();
            $table->string('name_relations')->nullable();
            $table->foreignId('usaha_id')->index()->nullable();
            $table->string('access_key',10)->nullable()->comment("xxxxxxxxxx");
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
            $table->dropColumn(
                [
                    'username', 'alamat', 'telpon', 'kota',
                    'profilePicture', 'active',
                    'relations_id', 'name_relations',
                    'usaha_id','access_key'
                ]
            );
            $table->dropSoftDeletes();
        });
    }
}
