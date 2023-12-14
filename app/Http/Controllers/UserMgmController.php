<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use File;

class UserMgmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinsi = DB::table('provinces')->orderBy('name', 'asc')->get();
        $user = DB::table("users")->orderBy('id', 'asc')
            ->leftJoin('cities','users.cities_id','=','cities.id')
            ->leftJoin('usaha','users.usaha_id','=','usaha.id')
            ->select([
                'users.*',
                'cities.name as kota',
                'cities.province_id as prov_id',
                'usaha.nama as nama_usaha'
            ])
            ->where('users.id', Auth::user()->id)
            ->first();

        return view('ui_admin.pages.lain-lain.user_management',
            ['user' => $user, 'provinsi' => $provinsi]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        #create your data here
        // $data = $request->all();
        // return response()->json($data);

        // $username = implode("-", explode(" ",strtolower(trim($request->nama_user))));

        $password = ($request->password != null) ? Hash::make($request->password) : Hash::make('123456') ;

        #cara 1
        $user = new User;
        $user->name        = trim($request->nama_user);
        $user->telpon      = $request->telpon;
        $user->alamat      = $request->alamat;
        $user->cities_id   = $request->kota;
        $user->prov_id     = $request->provinsi;
        $user->username    = $request->username;
        $user->email       = trim(strtolower($request->email));
        $user->password    = $password;
        $user->active      = $request->status;
        $user->role_id     = $request->posisi;
        $user->access_key  = Auth::user()->access_key;
        $user->usaha_id    = Auth::user()->usaha_id;
        $sukses            = $user->save();

        $info_upload = "Gambar User Tidak di-Upload";

        if ($sukses) {
            if($request->hasFile('gambar')){
                $input = $request->all();
                $rules = [
                    'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
                ];
                $messages = [
                    // 'gambar.required'  => 'Photo Profile Wajib Di-Upload',
                    'gambar.image' => 'File Logo harus File Gambar.',
                    'gambar.mimes' => 'Tipe File hanya (:values).',
                    'gambar.max'   => 'Ukuran file terlalu besar, Maks. :max Kilobyte.',
                ];

                $validator = Validator::make($input, $rules, $messages);

                if($validator->fails()){
                    return response()->json([
                        'pesan' =>  [
                            'status' => 'error',
                            'ket' => $validator->errors()->all(),
                        ],
                    ]);
                }

                // menyimpan data file yang diupload ke variabel $file
                $file     = $request->file("gambar");
                $fileExt  = $file->getClientOriginalExtension();
                $fileName = $user->id.'-'.implode("-", explode(" ",strtolower($user->name))).'.'.$fileExt;
                $tujuan_upload = 'profile';

                $file->move(public_path($tujuan_upload), $fileName);

                $info_upload = "Gambar User Berhasil di-Upload";
                $user->profilePicture  = $fileName;
                $upload = $user->save();
            }

            // response
            return response()->json([
                'pesan' =>  [
                    'status' => 'success',
                    'ket' => [
                        'Data User Berhasil di-Buat',
                        $info_upload,
                    ],
                ],
            ]);
        } else {
            // response
            return response()->json([
                'pesan' =>  [
                    'status' => 'error',
                    'ket' => [
                        'Data User Gagal di-Buat',
                        $info_upload,
                    ],
                ],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);
        // return $request;

        $file_lama = $user->profilePicture;

        $password = ($request->password != null) ? Hash::make($request->password) : $user->password;

        $info_upload = "Gambar User Tidak di-Upload";
        $upload = false;

        if($request->hasFile('gambar')){
            $input = $request->all();
            $rules = [
                'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ];
            $messages = [
                // 'gambar.required'  => 'Photo Profile Wajib Di-Upload',
                'gambar.image'     => 'File Gambar harus File Gambar.',
                'gambar.mimes'     => 'Tipe File hanya (:values).',
                'gambar.max'       => 'Ukuran file terlalu besar, Maks. :max Kilobyte.',
            ];

            $validator = Validator::make($input, $rules, $messages);

            if($validator->fails()){
                return response()->json([
                    'pesan' =>  [
                        'status' => 'error',
                        'ket' => $validator->errors()->all()
                    ],
                ]);
            }

            // menyimpan data file yang diupload ke variabel $file
            $file     = $request->file("gambar");
            $fileExt  = $file->getClientOriginalExtension();
            $fileName = $user->id.'-'.implode("-", explode(" ",strtolower($user->nama))).'.'.$fileExt;
            $tujuan_upload = 'profile';

            $file->move(public_path($tujuan_upload), $fileName);

            $info_upload = "Logo User Berhasil di-Upload";
            $user->profilePicture = $fileName;
            $upload = $user->save();

            //hapus gambar lama jika ada perubahan nama file
            if ($file_lama != $fileName) {
                if(File::exists(public_path('profile/'.$file_lama))){
                    File::delete(public_path('profile/'.$file_lama));
                    $info_upload = "Logo User Berhasil di-Update";
                }
            }
        }

        $update = User::where('id', $id)->update([
            'name'        => trim($request->nama_user),
            'telpon'      => $request->telpon,
            'alamat'      => $request->alamat,
            'cities_id'   => $request->kota,
            'prov_id'     => $request->provinsi,
            // 'username'    => $request->username,
            // 'email'       => trim(strtolower($request->email)),
            'password'    => $password,
            'active'      => $request->status,
            'role_id'     => $request->posisi,
        ]);


        if ($update || $upload) {
            // response
            return response()->json([
                'pesan' =>  [
                    'status' => 'success',
                    'ket' => [
                        'Data User Berhasil di-Update',
                        $info_upload,
                    ],
                ],
            ]);
        } else {
            // response
            return response()->json([
                'pesan' =>  [
                    'status' => 'error',
                    'ket' => [
                        'Data User Gagal di-Update',
                        $info_upload,
                    ],
                ],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function loadDataUser() {
        $user = DB::table("users")
            ->leftJoin('cities','users.cities_id','=','cities.id')
            ->leftJoin('usaha','users.usaha_id','=','usaha.id')
            ->select([
                'users.*',
                'cities.name as kota',
                'cities.province_id as prov_id',
                'usaha.nama as nama_usaha'
            ])
            ->where('users.usaha_id', Auth::user()->usaha_id)
            ->get();

        return response()->json([
            'user' => $user,
        ]);

    }

    public function updateStatus(Request $request, $id){
        $user = User::find($id);

        // return $user;

        $user->status = $request->status;
        $sukses = $user->save();

        if ($sukses) {
            $info_status = 'success';
            $ket = 'Toko Berhasil di-Aktifkan';

            // Buat Table User
            $previx = strtolower($user->access_key.'_');

            // 1. Table Master Data
            Schema::dropIfExists($previx . 'satuans');
            Schema::connection('mysql')->create($previx . 'satuans', function (Blueprint $table) {
                $table->id();
                $table->string('tipe')->unique()->comment('CTN.BOX.PCS');
                $table->boolean('konversi')->default(0);
                $table->string('nilai')->comment('100.50.1');
                $table->string('kode',5)->comment('B.S.K');
                // $table->foreignId('usaha_id')->nullable();
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
                // $table->foreignId('usaha_id')->nullable();
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
                $table->string('code',13)->index()->nullable();
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
                // $table->foreignId('usaha_id')->nullable();
                $table->timestamp('created_at')->useCurrent();
                $table->timestamp('updated_at')->default(DB::raw('NULL ON UPDATE CURRENT_TIMESTAMP'))->nullable();
                $table->timestamp('deleted_at')->nullable();
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

        } else {
            $info_status = 'error';
            $ket = 'Toko Gagal di-Aktifkan';
        }
        // response
        return response()->json([
            'pesan' =>  [
                'status' => $info_status,
                'ket' => [$ket],
            ],
        ]);
    }

    public function cekDataUser(Request $request) {

        if (str_contains($request, 'username')) {
            $cari = User::where('username', '=', trim($request->username));
        } else if (str_contains($request, 'telpon')) {
            $cari = User::where('telpon', '=', trim($request->telpon));
        } else {
            $cari = User::where('email', '=', trim($request->email));
        }

        $cari = $cari->exists(); // menghasilkan 1 / 0 (true/false)

        if ($cari) {
            return response()->json(false);
            // $info = "nama sudah ada"; // user found
            // $data = Satuan::where('tipe', '=', $request->kode_satuan)->first();
        } else {
            return response()->json(true);
            // $info = "nama belum ada"; // user not found
        }
        // return response()->json(['data'=>$data, 'status'=> $cari ,'message'=>$info]);
    }

}
