<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMidtransConfigTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('midtrans_config', function (Blueprint $table) {
            $table->id();
            $table->foreignId('usaha_id');
            $table->string('server_key')->unique();
            $table->string('client_key')->unique();
            $table->boolean('is_production')->default(false);
            $table->boolean('is_sanitized')->default(true);
            $table->boolean('is_3ds')->default(true);
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
        Schema::dropIfExists('midtrans_config');
    }
}
