<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pakets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('gambar');
            $table->integer('duration')->default(0);
            $table->integer('disc')->default(0);
            $table->integer('lama_disc')->default(0);
            $table->integer('biaya')->default(0);
            $table->string('uraian')->nullable();
            $table->string('max_features')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('warna_header')->nullable();
            $table->string('warna_body')->nullable();
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
        Schema::dropIfExists('pakets');
    }
}
