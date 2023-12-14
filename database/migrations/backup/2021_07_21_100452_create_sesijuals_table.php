<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSesijualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sesijuals', function (Blueprint $table) {
            $table->id();
            $table->string('kode_sesi',10)->index();
            $table->date('tanggal');
            $table->foreignId('user_id');
            $table->integer('no_trx')->default(0);
            $table->double('kas_awal',10,2)->default(0);
            $table->double('total',10,2)->default(0);
            $table->double('tunai',10,2)->default(0);
            $table->double('kartu',10,2)->default(0);
            $table->double('kredit',10,2)->default(0);
            $table->double('diskon',10,2)->default(0);
            $table->double('setoran',10,2)->default(0);
            $table->integer('k100000')->default(0);
            $table->integer('k50000')->default(0);
            $table->integer('k20000')->default(0);
            $table->integer('k10000')->default(0);
            $table->integer('k5000')->default(0);
            $table->integer('k1000')->default(0);
            $table->integer('k500')->default(0);
            $table->integer('l1000')->default(0);
            $table->integer('l500')->default(0);
            $table->integer('l100')->default(0);
            $table->integer('l50')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sesijuals');
    }
}
