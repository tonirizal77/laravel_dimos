<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHutangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hutangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_id')->index();
            $table->foreignId('nota_id')->index();
            $table->string('no_nota',14)->index();
            $table->date('tanggal');
            $table->double('jumlah',10,2)->default(0);
            $table->char('status',1)->comment('1-Nota Baru, 2-Angsuran, 3-Lunas');
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
        Schema::dropIfExists('hutangs');
    }
}
