<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataBelisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_beli', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nota_id')->index();
            $table->string('no_nota',14)->index();
            $table->string('code',13)->index();
            $table->integer('qty')->default(0);
            $table->string('satuan',10)->default("PCS");
            $table->double('harga_beli')->default(0);
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
        Schema::dropIfExists('data_beli');
    }
}
