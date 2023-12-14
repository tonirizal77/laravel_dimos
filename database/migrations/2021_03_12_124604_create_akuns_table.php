<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akuns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paket_id');
            $table->foreignId('usaha_id')->unique();
            $table->string('order_no',10)->nullable();
            $table->char('status',1)->default('3')->comment('1. Active, 2.Pending, 3.Non-active');
            $table->integer('biaya')->default(0);
            $table->integer('durasi')->default(0);
            $table->string('keterangan')->nullable();
            $table->date('start_date')->nullable();
            $table->date('expire_date')->nullable();
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
        Schema::dropIfExists('akuns');
    }
}
