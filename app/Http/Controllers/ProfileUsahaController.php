<?php

namespace App\Http\Controllers;

use App\Models\Usaha;
use App\Models\Paket;
use App\Models\User;
use App\Models\Akun;
use App\Models\Order_Paket;

use App\Http\Controllers\FrontendController;
use App\Http\Controllers\DatabaseClientController;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use File;

class ProfileUsahaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role_id == 1 || Auth::user()->role_id == 2) {

            $paket = Paket::all();
            $akun = Akun::orderBy('id','desc')
                ->where('usaha_id', Auth::user()->usaha_id)
                ->first();

            return view('ui_admin.pages.lain-lain.profile_usaha',[
                'paket' => $paket,
                'akun' => $akun
            ]);
        } else {
            return redirect()->route('dashboard.index');
        }
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
        #create or update your data here
        // $data = $request->all();
        // return $data;

        #cara 1
        $usaha = new Usaha;
        $usaha->nama        = $request->nama;
        $usaha->alamat      = $request->alamat;
        $usaha->telpon      = $request->telpon;
        $usaha->cities_id   = $request->kota;
        $usaha->province_id = $request->provinsi;
        $usaha->email       = strtolower($request->email);
        $usaha->access_key  = strtolower(Str::random(10));
        $sukses             = $usaha->save();
        $info_upload = "Logo Usaha Tidak di-Upload";

        if ($sukses) {
            //update user
            #cara 2 - update
            $update = User::where('id', Auth::user()->id)
            // ->where(Auth::user()->role_id == 1) //tambahan
            ->update([
                'usaha_id'   => $usaha->id,
                'access_key' => $usaha->access_key,
            ]);

            if($request->hasFile('inputFile')){
                $input = $request->all();
                $rules = [
                    'inputFile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:500',
                ];
                $messages = [
                    // 'inputFile.required'  => 'Photo Profile Wajib Di-Upload',
                    'inputFile.image'     => 'File Logo harus File Gambar.',
                    'inputFile.mimes'     => 'Tipe File hanya (:values).',
                    'inputFile.max'       => 'Ukuran file terlalu besar, Maks. :max Kilobyte.',
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
                $file     = $request->file("inputFile");
                $fileExt  = $file->getClientOriginalExtension();
                $fileName = "logo-".implode("-", explode(" ",strtolower($usaha->nama))).'.'.$fileExt;
                $folderUpload = 'profile';

                $file->move($folderUpload, $fileName);

                $info_upload = "Logo Usaha Berhasil di-Upload";

                $update = Usaha::where('id', $usaha->id)->update(['logo' => $fileName]);
            }

            // response
            return response()->json([
                'pesan' =>  [
                    'status' => 'success',
                    'ket' => [
                        'Data Toko Berhasil di-Buat',
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
                        'Data Toko Gagal di-Buat',
                        $info_upload,
                    ],
                ],
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Usaha  $usaha
     * @return \Illuminate\Http\Response
     */
    public function show(Usaha $usaha)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Usaha  $usaha
     * @return \Illuminate\Http\Response
     */
    public function edit(Usaha $usaha)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Usaha  $usaha
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $usaha = Usaha::find($id);
        // return $request;

        $file_lama = $usaha->logo;

        $info_upload = "Logo Usaha Tidak di-Upload";
        $sukses = false;
        $upload = false;

        $folderUpload = 'images/profile';

        if($request->hasFile('ganti_logo')){
            $input = $request->all();
            $rules = [
                'ganti_logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1000',
            ];
            $messages = [
                // 'ganti_logo.required'  => 'Photo Profile Wajib Di-Upload',
                'ganti_logo.image'     => 'File Logo harus File Gambar.',
                'ganti_logo.mimes'     => 'Tipe File hanya (:values).',
                'ganti_logo.max'       => 'Ukuran file terlalu besar, Maks. :max Kilobyte.',
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

            $file     = $request->file("ganti_logo");
            $fileExt  = $file->getClientOriginalExtension();
            $fileName = "logo-".implode("-", explode(" ",strtolower($usaha->nama))).'.'.$fileExt;
            // $fileName = $file->getClientOriginalName();
            // $filePath = $file->getRealPath();
            // $fileSize = $file->getSize();
            // $fileMime = $file->getMimeType();

            $file->move($folderUpload, $fileName);

            // $file->storeAs('images', $fileName); //upload ke storage/app/images

            $info_upload = "Logo Usaha Berhasil di-Upload";
            $usaha->logo  = $fileName;
            $upload = $usaha->save();

            //hapus gambar lama jika ada perubahan nama file
            if ($file_lama != $fileName) {
                if(File::exists( $folderUpload.'/'.$file_lama )){
                    File::delete( $folderUpload.'/'.$file_lama );
                    $info_upload = "Logo Usaha Berhasil di-Update";
                }
            }
        } else {
            // all change
            $usaha->nama        = $request->nama;
            $usaha->alamat      = $request->alamat;
            $usaha->telpon      = $request->telpon;
            $usaha->cities_id   = $request->kota;
            $usaha->province_id = $request->provinsi;
            $usaha->email       = $request->email;
            $sukses             = $usaha->save();
            // status dan toko_online (belum di-save)

            if($request->hasFile('inputFile')){
                $input = $request->all();
                $rules = [
                    'inputFile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1000',
                ];
                $messages = [
                    // 'inputFile.required'  => 'Photo Profile Wajib Di-Upload',
                    'inputFile.image'     => 'File Logo harus File Gambar.',
                    'inputFile.mimes'     => 'Tipe File hanya (:values).',
                    'inputFile.max'       => 'Ukuran file terlalu besar, Maks. :max Kilobyte.',
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
                $file     = $request->file("inputFile");
                $fileExt  = $file->getClientOriginalExtension();
                // $fileName = $file->getClientOriginalName();
                $fileName = "logo-".implode("-", explode(" ",strtolower($usaha->nama))).'.'.$fileExt;
                $filePath = $file->getRealPath();
                $fileSize = $file->getSize();
                $fileMime = $file->getMimeType();

                $file->move($folderUpload, $fileName);

                $info_upload = "Logo Usaha Berhasil di-Upload";
                $usaha->logo  = $fileName;
                $upload = $usaha->save();

                //hapus gambar lama jika ada perubahan nama file
                if ($file_lama != $fileName) {
                    if(File::exists( $folderUpload.'/'.$file_lama )){
                        File::delete( $folderUpload.'/'.$file_lama );
                        $info_upload = "Logo Usaha Berhasil di-Update";
                    }
                }
            }

        }

        if ($sukses || $upload) {
            // response
            return response()->json([
                'pesan' =>  [
                    'status' => 'success',
                    'ket' => [
                        'Data Toko Berhasil di-Update',
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
                        'Data Toko Gagal di-Update',
                        $info_upload,
                    ],
                ],
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Usaha  $usaha
     * @return \Illuminate\Http\Response
     */
    public function destroy(Usaha $usaha)
    {
        //
    }

    public function loadDataToko() {
        $provinsi = DB::table('provinces')->orderBy('name', 'asc')->get();

        $usaha = DB::table("usaha")
            ->where('usaha.id', Auth::user()->usaha_id)
            ->leftJoin('cities','usaha.cities_id','=','cities.id')
            ->select([
                'usaha.nama',
                'usaha.telpon',
                'usaha.alamat',
                'usaha.cities_id',
                'usaha.province_id as prov_id',
                'usaha.email',
                'usaha.logo',
                'usaha.id',
                'usaha.status',
                'usaha.status_akun',
                'cities.name as kota',
            ])
            ->first();

        if (Auth::user()->role_id == 1 ) {
            $info = [
                'status' => 'success',
                'info' => 'Hak Akses Anda Di-Terima',
            ];

        } else {
            $info = [
                'status' => 'error',
                'info' => 'Hak Akses Anda Di-Tolak',
            ];
        }

        return response()->json([
            'pesan' => $info,
            'usaha' => $usaha,
            'provinsi' => $provinsi
        ]);

    }

    // Update Status Toko (Free Paket)
    public function updateStatus(Request $request, $id){

        // return $request;

        $paket = $request->paket;
        $status = $request->status;

        $usaha = Usaha::find($id);
        $usaha->status      =  $status;
        $usaha->status_akun =  $status;
        $sukses = $usaha->save();

        if ($paket == 1) {
            $durasi = 14;
            $tgl_awal = date('Y-m-d', strtotime(\Carbon\Carbon::now()));
            $tgl_akhir =  date('Y-m-d', strtotime($tgl_awal . ' + ' . $durasi . ' days'));

            $no_order = 'P'.$paket.'-'.strtoupper(Str::random(7));

            // buat Order
            $order = new Order_Paket;
            $order->order_no        = $no_order;
            $order->paket_id        = $paket;
            $order->usaha_id        = Auth::user()->usaha_id;
            $order->durasi          = $durasi;
            $order->total           = 0;
            $order->order_status    = '2';
            $order->payment_status  = '2';
            $order->save();

            // buat Akun
            $akun = Akun::updateOrCreate(
                [   'usaha_id' => Auth::user()->usaha_id ],
                [
                    'paket_id'    => 1,
                    'order_no'    => $no_order,
                    'status'      => '1',
                    'biaya'       => 0,
                    'durasi'      => $durasi,
                    'keterangan'  => 'Paket Gratis',
                    'start_date'  => $tgl_awal,
                    'expire_date' => $tgl_akhir,
                ]
            );
        }

        if ($sukses) {
            $info_status = 'success';
            $ket = 'Toko Berhasil di-Aktifkan';

            // Buat Database Client
            return redirect()->action([DatabaseClientController::class]);
        } else {
            $info_status = 'error';
            $ket = 'Toko Gagal di-Aktifkan';
        }
        // response
        return response()->json([
            'pesan' =>  [
                'status' => $info_status,
                'ket' => $ket,
            ],
        ]);
    }
}
