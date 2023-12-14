<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MidtransController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\UploadFileController;
use App\Http\Controllers\SesijualController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\ProfileUserController;
use App\Http\Controllers\ProfileUsahaController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\OrderPaketController;
use App\Http\Controllers\UserMgmController;
use App\Http\Controllers\HistoryPaymentController;
use App\Http\Controllers\DatabaseClientController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/** roules and authentication
 * source 1 : https://gist.github.com/akunbeben/0a487f7149c87709c4d8e82c40e20b19
 * source 2 : https://masteringbackend.com/posts/multiple-role-based-authentication-in-laravel/
*/

// Auth::routes(['verify' => true]);

Route::get('/', [FrontendController::class, 'index'])->name('homepage');

Route::get('login', [AuthController::class, 'showFormLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);

Route::get('register', [AuthController::class, 'showFormRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);

Route::post('cekDataUser', [CustomerController::class,'cekDataUser'])->name('cekDataUser'); //register

// Midtrans Related
Route::prefix('payment')->group(function () {
    Route::post('notification', [MidtransController::class, 'callback']);
    Route::get('finish', [MidtransController::class, 'success']); //sukses payment dan lunas
    Route::get('unfinish', [MidtransController::class, 'unfinish']); //sukses payment blm lunas
    Route::get('error', [MidtransController::class, 'error']); //gagal request payment
});

// Route authenticated users
// Route::group(['middleware' => ['auth','cache.headers:public;etag']], function() {
// Route::middleware(['auth', 'cache.headers:public'])->group(function () {
Route::middleware(['auth'])->group(function () {
    /**
     * Route Global
    */
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('cari-barang/{code}', [ProductController::class,'caribarang']);

    Route::post('load-kota', [CitiesController::class,'loadKota'])->name('LoadKota');

    Route::post('profile-user/cekDataUser', [ProfileUserController::class,'cekDataUser']);
    Route::resource('profile-user', ProfileUserController::class)
        ->except(['store','create','show','edit','destroy']);

    Route::resource('dashboard', DashboardController::class)
            ->except(['store','create','show','edit','destroy']);

    // Group route ADMIN
    Route::group([
        'prefix'=> 'admin',
        'middleware' => ['role:admin']
        ], function () {

            Route::get('create-dataclient', DatabaseClientController::class)->name('create-dataclient');

            Route::prefix('usaha')->group(function () {
                Route::get('load-toko', [ProfileUsahaController::class,'loadDataToko'])->name('loadDataToko');
                Route::post('update-status-toko/{id}', [ProfileUsahaController::class,'updateStatus'])->name('updateStatusToko');

                Route::resource('profile-usaha',ProfileUsahaController::class)
                    ->except(['create','show','edit','destroy']);

                Route::get('load-akuns-toko', [AkunController::class,'loadAkunUsaha']);
                Route::resource('account', AkunController::class);

                Route::resource('orders', OrderPaketController::class)
                    ->except(['create', 'show', 'edit','update','destroy']);

                Route::post('history-payment', [HistoryPaymentController::class, 'store']);
            });

            // Route::prefix('pengaturan')->group(function () {
            //     //
            // });

            // status toko aktif
            Route::group(['middleware' => 'status:1'], function () {

                Route::prefix('master-data')->group(function () {
                    Route::post('products/cekCode', [ProductController::class,'cekCode']);
                    // Route::post('products/cari-barang/{code}', [ProductController::class,'caribarang']);
                    Route::get('products/load-data', [ProductController::class,'loadDataAjax']);
                    Route::resource('products', ProductController::class)
                        ->except(['create']);

                    Route::get('category/load-data', [CategoryController::class,'loadDataAjax']);
                    Route::get('category/load-kategori', [CategoryController::class,'loadDataKategori']);
                    Route::post('category/multi-delete', [CategoryController::class,'multidelete']);
                    Route::post('category/update-status', [CategoryController::class,'updateStatus']);
                    Route::post('category/update-name', [CategoryController::class,'updateName']);
                    Route::resource('category', CategoryController::class)
                        ->except('create','edit','show','update','destroy');

                    Route::post('satuans/cekTipe', [SatuanController::class,'cekTipe']);
                    Route::get('satuans/load-data', [SatuanController::class,'loadDataAjax']);
                    Route::resource('satuans', SatuanController::class)
                        ->except('create','edit','show');

                    Route::get('suppliers/load-data', [SupplierController::class,'loadDataAjax']);
                    Route::resource('suppliers', SupplierController::class);

                    Route::get('customers/load-data', [CustomerController::class,'loadDataCustomer']);
                    Route::post('customers/cekDataUser', [CustomerController::class,'cekDataUser']);
                    Route::resource('customers', CustomerController::class)->except(['create', 'show', 'destroy']);
                });

                Route::prefix('penjualan')->group(function () {
                    Route::get('load-data-barang', [PenjualanController::class,'loadDataBarang']);
                    Route::get('load-data-customer', [PenjualanController::class, 'loadDataCustomer']);
                    Route::get('load-data-nota/{id}', [PenjualanController::class, 'loadDataJual']);
                    Route::post('load-nota-penjualan', [PenjualanController::class, 'loadNotaJual']);
                    Route::post('getnotrx', [PenjualanController::class, 'getNoTrx']);
                    Route::resource('pos-kasir', PenjualanController::class)->except(['crate','show','edit']);

                    Route::post('sesi-penjualan/cekSesi', [SesijualController::class,'cekSesi']);
                    Route::post('getSesiJual', [SesijualController::class, 'getSesiJual']);
                    Route::resource('sesi-penjualan', SesijualController::class)
                        ->except(['create', 'show', 'edit','update','destroy']);
                });

                Route::prefix('pembelian')->group(function () {
                    Route::post('getnotrx', [PembelianController::class, 'getNoTrx']);
                    Route::post('load-nota-pembelian/{isShow}', [PembelianController::class, 'loadNotaBeli']);
                    Route::get('load-data-nota/{id}', [PembelianController::class, 'loadDataBeli']);
                    Route::resource('nota-pembelian', PembelianController::class);
                });

                Route::prefix('pengaturan')->group(function () {
                    Route::get('load-data-user', [UserMgmController::class,'loadDataUser']);
                    Route::post('user-management/cekDataUser', [UserMgmController::class,'cekDataUser']);
                    Route::resource('user-management',UserMgmController::class);
                });

            });
        }
    );

    // Group route KASIR
    Route::group([
        'prefix'=> 'kasir',
        'middleware' => ['role:kasir']
        ], function () {
            Route::group(['middleware' => 'status:1'], function () {

                Route::prefix('master-data')->group(function () {
                    Route::get('customers/load-data', [CustomerController::class,'loadDataCustomer']);
                    Route::post('customers/cekDataUser', [CustomerController::class,'cekDataUser']);
                    Route::resource('customers', CustomerController::class)->except(['create', 'show', 'destroy']);
                });

                Route::prefix('penjualan')->group(function () {
                    Route::get('load-data-barang', [PenjualanController::class,'loadDataBarang']);
                    Route::get('load-data-customer', [PenjualanController::class, 'loadDataCustomer']);
                    Route::get('load-data-nota/{id}', [PenjualanController::class, 'loadDataJual']);
                    Route::post('load-nota-penjualan', [PenjualanController::class, 'loadNotaJual']);
                    Route::post('getnotrx', [PenjualanController::class, 'getNoTrx']);
                    Route::resource('pos-kasir', PenjualanController::class)->except(['crate','show','edit']);

                    Route::post('sesi-penjualan/cekSesi', [SesijualController::class,'cekSesi']);
                    Route::post('getSesiJual', [SesijualController::class, 'getSesiJual']);
                    Route::resource('sesi-penjualan', SesijualController::class)
                        ->except(['create', 'show', 'edit','update','destroy']);
                });
            });
        }
    );

    // Group route USER
    Route::group([
        'prefix'=> 'user',
        'middleware' => 'role:user'
        ], function () {
            // status toko aktif
            Route::group(['middleware' => 'status:1'], function () {

                Route::prefix('master-data')->group(function () {
                    Route::post('products/cekCode', [ProductController::class,'cekCode']);
                    // Route::post('products/cari-barang/{code}', [ProductController::class,'caribarang']);
                    Route::get('products/load-data', [ProductController::class,'loadDataAjax']);
                    Route::resource('products', ProductController::class)
                        ->except(['create']);

                    Route::get('category/load-data', [CategoryController::class,'loadDataAjax']);
                    Route::get('category/load-kategori', [CategoryController::class,'loadDataKategori']);
                    Route::post('category/multi-delete', [CategoryController::class,'multidelete']);
                    Route::post('category/update-status', [CategoryController::class,'updateStatus']);
                    Route::post('category/update-name', [CategoryController::class,'updateName']);
                    Route::resource('category', CategoryController::class)
                        ->except('create','edit','show','update','destroy');

                    Route::post('satuans/cekTipe', [SatuanController::class,'cekTipe']);
                    Route::get('satuans/load-data', [SatuanController::class,'loadDataAjax']);
                    Route::resource('satuans', SatuanController::class)
                        ->except('create','edit','show');

                    Route::get('suppliers/load-data', [SupplierController::class,'loadDataAjax']);
                    Route::resource('suppliers', SupplierController::class);

                    Route::get('customers/load-data', [CustomerController::class,'loadDataCustomer']);
                    Route::post('customers/cekDataUser', [CustomerController::class,'cekDataUser']);
                    Route::resource('customers', CustomerController::class)
                        ->except(['create', 'show', 'destroy']);
                });

                Route::prefix('penjualan')->group(function () {
                    Route::get('load-data-barang', [PenjualanController::class,'loadDataBarang']);
                    Route::get('load-data-customer', [PenjualanController::class, 'loadDataCustomer']);
                    Route::get('load-data-nota/{id}', [PenjualanController::class, 'loadDataJual']);
                    Route::post('load-nota-penjualan', [PenjualanController::class, 'loadNotaJual']);
                    Route::post('getnotrx', [PenjualanController::class, 'getNoTrx']);
                    Route::resource('pos-kasir', PenjualanController::class)->except(['crate','show','edit']);

                    Route::post('sesi-penjualan/cekSesi', [SesijualController::class,'cekSesi']);
                    Route::post('getSesiJual', [SesijualController::class, 'getSesiJual']);
                    Route::resource('sesi-penjualan', SesijualController::class)
                        ->except(['create', 'show', 'edit','update','destroy']);
                });

                Route::prefix('pembelian')->group(function () {
                    Route::post('getnotrx', [PembelianController::class, 'getNoTrx']);
                    Route::post('load-nota-pembelian/{isShow}', [PembelianController::class, 'loadNotaBeli']);
                    Route::get('load-data-nota/{id}', [PembelianController::class, 'loadDataBeli']);
                    Route::resource('nota-pembelian', PembelianController::class);
                });
            });
        }
    );

    // Group route Owner
    Route::group([
        'prefix'=> 'owner',
        'middleware' => 'role:owner'
        ], function () {
            return "Owner Page";
        }
    );
});

