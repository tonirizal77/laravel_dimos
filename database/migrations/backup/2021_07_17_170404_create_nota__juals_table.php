<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaJualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_jual', function (Blueprint $table) {
            $table->id();
            $table->string('no_nota',15)->index()->comment("P1-100277-001");
            $table->date('tanggal');
            $table->foreignId('customer_id')->index();
            $table->double('brutto',10,2)->default(0);
            $table->double('disc',10,2)->default(0);
            $table->double('total',10,2)->default(0);
            $table->double('tunai',10,2)->default(0);
            $table->double('kredit',10,2)->default(0);
            $table->double('kartu',10,2)->default(0);
            $table->integer('tempo')->default(14);
            $table->date('tgl_tempo')->nullable();
            $table->foreignId('user_id')->index();
            // $table->softDeletes();
            // $table->timestamps();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nota_jual');
    }
}
