<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Models\Usaha;

class DatabaseClientController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Buat Database Table
        // $usaha = Usaha::where('id', Auth::user()->usaha_id)->first();
        $usaha = Usaha::find(Auth::user()->usaha_id);
        $previx = $usaha->access_key.'_';

        if ($usaha != null) {
            if ($usaha->status_db == 0)
            {
                // 1. Table Master Data
                Schema::dropIfExists($previx . 'satuans');
                Schema::connection('mysql')->create($previx . 'satuans', function (Blueprint $table) {
                    $table->id();
                    $table->string('tipe')->unique()->comment('CTN.BOX.PCS');
                    $table->boolean('konversi')->default(0);
                    $table->string('nilai')->comment('100.50.1');
                    $table->string('kode',5)->comment('B.S.K');
                    $table->timestamp('created_at')->useCurrent();
                    $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                    $table->timestamp('deleted_at')->nullable();
                });

                Schema::dropIfExists($previx . 'categories');
                Schema::connection('mysql')->create($previx . 'categories', function (Blueprint $table) {
                    $table->id();
                    $table->string('name');
                    $table->string('icons')->nullable();
                    $table->boolean('active')->default(true);
                    $table->timestamp('created_at')->useCurrent();
                    $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                    $table->timestamp('deleted_at')->nullable();
                });

                Schema::dropIfExists($previx . 'suppliers');
                Schema::connection('mysql')->create($previx . 'suppliers', function (Blueprint $table) {
                    $table->id();
                    $table->string('nama');
                    $table->string('alamat');
                    $table->string('telpon')->nullable();
                    $table->foreignId('prov_id')->nullable();
                    $table->foreignId('kota_id')->nullable();
                    $table->boolean('status')->default(true);
                    $table->timestamp('created_at')->useCurrent();
                    $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                    $table->timestamp('deleted_at')->nullable();
                });

                Schema::dropIfExists($previx . 'products');
                Schema::connection('mysql')->create($previx . 'products', function (Blueprint $table) {
                    $table->id();
                    $table->string('code',13)->unique();
                    $table->string('description')->nullable();
                    $table->string('name');
                    $table->string('gambar')->nullable();
                    $table->foreignId('kategory_id');
                    $table->string('sat_beli',50)->nullable();
                    $table->string('sat_jual',50)->nullable();
                    $table->string('sat_konversi',50)->nullable();
                    $table->string('nil_konversi',50)->nullable();
                    $table->double('berat',8,2)->default(0)->comment('Satuan Kg');
                    $table->double('harga_beli',10,2)->default(0);
                    $table->double('harga_jual',10,2)->default(0);
                    $table->double('harga_modal',10,2)->default(0);
                    $table->double('stock_aw',10,2)->default(0);
                    $table->double('stock_ak',10,2)->default(0);
                    $table->timestamp('created_at')->useCurrent();
                    $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                    $table->timestamp('deleted_at')->nullable();
                });

                Schema::dropIfExists($previx . 'outlets');
                Schema::connection('mysql')->create($previx . 'outlets', function (Blueprint $table) {
                    $table->id();
                    $table->string('code',3)->unique();
                    $table->string('name',25);
                    $table->string('lokasi',50);
                    $table->timestamp('created_at')->useCurrent();
                    $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                });

                // 2. Table Transaction
                Schema::dropIfExists($previx . 'nota_jual');
                Schema::connection('mysql')->create($previx . 'nota_jual', function (Blueprint $table) {
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
                    $table->timestamp('created_at')->useCurrent();
                    $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                    $table->timestamp('deleted_at')->nullable();
                });
                Schema::dropIfExists($previx . 'data_jual');
                Schema::connection('mysql')->create($previx . 'data_jual', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('nota_id')->index();
                    $table->string('no_nota',15)->index();
                    $table->string('code',13)->index();
                    $table->integer('qty')->default(0);
                    $table->string('satuan',10)->default("PCS");
                    $table->double('harga_beli')->default(0);
                    $table->double('harga_jual')->default(0);
                    $table->double('disc')->default(0);
                    $table->timestamp('created_at')->useCurrent();
                    $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                    $table->timestamp('deleted_at')->nullable();
                });

                Schema::dropIfExists($previx . 'hutangs');
                Schema::create($previx . 'hutangs', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('supplier_id')->index();
                    $table->foreignId('nota_id')->index();
                    $table->string('no_nota',14)->index();
                    $table->date('tanggal');
                    $table->double('jumlah',10,2)->default(0);
                    $table->char('status',1)->comment('1-Nota Baru, 2-Angsuran, 3-Lunas');
                    $table->foreignId('user_id')->index();
                    $table->timestamp('created_at')->useCurrent();
                    $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                    $table->timestamp('deleted_at')->nullable();
                });

                Schema::dropIfExists($previx . 'piutangs');
                Schema::create($previx . 'piutangs', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('customer_id')->index();
                    $table->foreignId('nota_id')->index();
                    $table->string('no_nota',14)->index();
                    $table->date('tanggal');
                    $table->double('jumlah',10,2)->default(0);
                    $table->char('status',1)->comment('1-Nota Baru, 2-Angsuran, 3-Lunas');
                    $table->foreignId('user_id')->index();
                    $table->timestamp('deleted_at')->nullable();
                    $table->timestamp('created_at')->useCurrent();
                    $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                });

                Schema::dropIfExists($previx . 'sesijuals');
                Schema::create($previx . 'sesijuals', function (Blueprint $table) {
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

                Schema::dropIfExists($previx . 'nota_beli');
                Schema::create($previx . 'nota_beli', function (Blueprint $table) {
                    $table->id();
                    $table->string('no_nota',14)->index()->comment("NB-10027700001");
                    $table->date('tanggal');
                    $table->foreignId('supplier_id')->index();
                    $table->double('brutto',10,2)->default(0);
                    $table->double('disc',10,2)->default(0);
                    $table->double('total',10,2)->default(0);
                    $table->double('tunai',10,2)->default(0);
                    $table->double('kredit',10,2)->default(0);
                    $table->double('kartu',10,2)->default(0);
                    $table->integer('tempo')->default(14);
                    $table->date('tgl_tempo')->nullable();
                    $table->foreignId('user_id')->index();
                    $table->timestamp('created_at')->useCurrent();
                    $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                    $table->timestamp('deleted_at')->nullable();
                });

                Schema::dropIfExists($previx . 'data_beli');
                Schema::create($previx . 'data_beli', function (Blueprint $table) {
                    $table->id();
                    $table->foreignId('nota_id')->index();
                    $table->string('no_nota',14)->index();
                    $table->string('code',13)->index();
                    $table->integer('qty')->default(0);
                    $table->string('satuan',10)->default("PCS");
                    $table->double('harga_beli')->default(0);
                    $table->timestamp('created_at')->useCurrent();
                    $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                    $table->timestamp('deleted_at')->nullable();
                });

                $usaha->status_db = 1;
                $usaha->save();

            }
        }

        //return response
        return response()->json([
            'pesan' =>  [
                'status' => 'success',
                'ket' => 'Database Toko Berhasil di-Buat',
            ],
        ]);
    }
}
