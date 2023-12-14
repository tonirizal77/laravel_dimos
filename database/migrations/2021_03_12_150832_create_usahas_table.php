<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsahasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usaha', function (Blueprint $table) {
            $table->id();
            $table->string('logo')->nullable();
            $table->string('nama');
            $table->string('email')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telpon')->nullable();
            $table->foreignId('cities_id')->nullable();
            $table->foreignId('province_id')->nullable();
            $table->boolean('status')->default(0);
            $table->boolean('status_akun')->default(0);
            $table->boolean('status_db')->default(0);
            $table->string('access_key',10)->unique()->nullable()->comment("ex: 1234aBcDeF");
            $table->boolean('toko_online')->default(0);
            $table->char('tipe_usaha',1)->nullable()->comment('1:Distributor, 2:Store');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usaha');
    }
}
