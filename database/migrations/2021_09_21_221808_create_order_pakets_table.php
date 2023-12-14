<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPaketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_pakets', function (Blueprint $table) {
            $table->id();
            $table->string('order_no', 10)->unique()->comment('random(10)');
            $table->foreignId('paket_id');
            $table->foreignId('usaha_id');
            $table->integer('durasi')->default(0);
            $table->double('total', 10, 2)->default(0);
            $table->char('order_status',1)->comment('1=pending, 2=selesai, 3=batal');
            $table->enum('payment_status', ['0','1', '2', '3', '4'])->comment('0=Belum diproses, 1=Menunggu Pembayaran, 2=Sudah dibayar, 3=batal, 4=expired');
            $table->string('snap_token')->nullable();
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
        Schema::dropIfExists('order_pakets');
    }
}
