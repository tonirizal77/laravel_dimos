<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use Validator;
use Hash;
use File;

class ProfileUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinsi = DB::table('provinces')->orderBy('name', 'asc')->get();
        $user = DB::table("users")
            ->leftJoin('cities','users.cities_id','=','cities.id')
            ->leftJoin('usaha','users.usaha_id','=','usaha.id')
            ->select([
                'users.*',
                'cities.name as kota',
                'cities.province_id as prov_id',
                'usaha.nama as nama_usaha'
            ])
            ->where('users.role_id', Auth::user()->role_id)
            ->where('users.id', Auth::user()->id)
            ->first();

        return view('ui_admin.pages.lain-lain.profile_user',
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

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
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
        // return $user;
        // $validator = Validator::make($request->all(),
        //     [
        //         'inputFile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //         // 'name'      => 'required|min:5|max:35',
        //         // 'telpon'    => 'required|min:10',
        //         // 'tipe'      => 'required',
        //         // 'status'    => 'required',
        //         // 'alamat'    => 'required|min:10|max:255',
        //         // 'camat_id'  => 'required',
        //         // 'lurah_id'  => 'required',
        //         // 'password'  => 'required|min:6',
        //         // 'username'  => 'required|min:10|unique:users',
        //         // 'email'     => 'required|email|unique:users,email',
        //     ])->validate();

        // if ($request->iconfile != null) {
        //     //Change file name with time() and get extention file
        //     $imageName = time().'.'.$request->iconfile->extension();
        //     $request->iconfile->move(public_path('images'), $imageName);
        //     $category->icons = $imageName;
        // }

        #update user
        $user = User::find($id);

        $file_lama = $user->profilePicture;

        $user->name        = ucwords($request->nama_user);
        $user->telpon      = $request->telpon;
        $user->username    = $request->username;
        $user->email       = $request->email;
        $user->alamat      = $request->alamat;
        $user->cities_id   = $request->kota;
        $sukses            = $user->save();

        if ($sukses) {
            if($request->password != null ) {
                $password = Hash::make($request->password);
                // $update = User::where('id', $id)->update(['password'  => $password]);
                $user->password = $password;
                $user->save();
            }
        }

        $info_upload = "Tidak Ada Upload Photo User";
        if($request->hasFile('inputFile')){
            $input = $request->all();
            $rules = [
                'inputFile' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            ];
            $messages = [
                // 'inputFile.required'  => 'Photo Profile Wajib Di-Upload',
                'inputFile.image'     => 'File Photo harus File Gambar.',
                'inputFile.mimes'     => 'Tipe File hanya (:values).',
                'inputFile.max'       => 'Ukuran file terlalu besar, Maks. :max Kilobyte.',
            ];

            $validator = Validator::make($input, $rules, $messages);

            if($validator->fails()){
                return response()->json([
                    'pesan' =>  [
                        'status' => 'error',
                        'info' => $validator->errors()->all(),
                    ],
                ]);
            }



            // menyimpan data file yang diupload ke variabel $file
            $file     = $request->file("inputFile");
            $fileExt  = $file->getClientOriginalExtension();
            // $fileName = $file->getClientOriginalName();
            // $fileName = implode("-", explode(" ",strtolower($user->name))).'.'.$fileExt;
            $fileName = "user-".implode("-", explode(" ",strtolower($user->username))).'.'.$fileExt;
            $filePath = $file->getRealPath();
            $fileSize = $file->getSize();
            $fileMime = $file->getMimeType();
            $tujuan_upload = 'images/profile';

            $file->move($tujuan_upload, $fileName);

            $info_upload = "Photo User Berhasil di-Upload";

            // $update = User::where('id', $id)->update(['profilePicture' => $fileName]);
            $user->profilePicture = $fileName;
            $user->save();

            //hapus gambar lama jika ada perubahan nama file
            if ($file_lama != $fileName) {
                if(File::exists( $tujuan_upload.'/'.$file_lama )){
                    File::delete( $tujuan_upload.'/'.$file_lama );
                    $info_upload = "Photo User Berhasil di-Update";
                }
            }
        }

        if ($sukses) {
            return response()->json([
                'pesan' =>  [
                    'status' => 'success',
                    'info' => [
                        'Data User Berhasil di-Update',
                        $info_upload,
                    ],
                ],
            ]);
        } else {
            return response()->json([
                'pesan' =>  [
                    'status' => 'error',
                    'info' => [
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

    public function cekDataUser(Request $request) {
        $opr  = $request->opr; //edit or tambah
        $lama = $request->kodelama;
        $username = $request->username;

        if (str_contains($request, 'username')) {
            $cari = User::where('username', '=', trim($request->username));
        } else if (str_contains($request, 'telpon')) {
            $cari = User::where('telpon', '=', trim($request->telpon));
        } else {
            $cari = User::where('email', '=', trim($request->email));
        }

        $cari = $cari->exists(); // menghasilkan 1 / 0 (true/false)

        if ($cari) {
            if ($opr == 'tambah') {
                return response()->json(false); // invalid
            } else {
                if ($lama ==  $username) {
                    return response()->json(true); // abaikan
                } else {
                    return response()->json(false); // invalid
                }
            }
            // $info = "nama sudah ada"; // user found
        } else {
            // $info = "nama belum ada"; // user not found
            return response()->json(true);
        }

        // return response()->json([
        //     'status'=> $cari ,
        //     'message'=>$info,
        //     'opr'=>$opr,
        //     'lama'=>$lama
        // ]);
    }
}
