<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
// use DataTables;

use Validator;
use Hash;
use Session;

use App\Models\User;
use App\Models\Wilayah;
// use App\Models\Kelurahan;
// use App\Models\Kecamatan;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $wilayah = DB::table('wilayahs')->orderBy('id','asc')
            ->leftJoin('kelurahans','wilayahs.lurah_id','kelurahans.id')
            ->leftJoin('kecamatans','wilayahs.camat_id','kecamatans.id')
            ->select('wilayahs.*', 'kelurahans.name as lurah','kecamatans.name as camat')
            ->get();

        $data = ['wilayah'=>$wilayah];

        return view('ui_admin.pages.master-data.user', $data);
    }

    public function pendaftaran()
    {
        return view("ui_admin.pages.master-data.pendaftaran");
    }

    // get list data user
    // public function getAjax(){
    //     $users = DB::table('users')->orderBy('id','asc')
    //         ->leftJoin('wilayahs','users.wilayah_id','=','wilayahs.id')
    //         ->select('users.*','wilayahs.name as wilayah')
    //         ->get();

    //     return Response()->json($users);
    // }

    // public function getAjaxKurir(){
    //     $users = User::where('tipe','2')->get();
    //     return Response()->json($users);
    // }

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
        /**Start Contoh Custom Validation */
            // $rules = [
            //     'name'      => 'required|min:5|max:50',
            //     'username'  => 'required|min:5|unique:users',
            //     'email'     => 'required|email|unique:users,email',
            //     'telpon'    => 'required|min:10',
            //     'password'  => 'required|min:6',
            //     'alamat'    => 'required|min:10',
            //     'tipe'      => 'required',
            //     'status'    => 'required',
            //     'wilayah_id'  => 'required',
            // ];

            // $messages = [
            //     'name.required'         => 'Nama Lengkap wajib diisi',
            //     'name.min'              => 'Nama lengkap minimal 5 karakter',
            //     'name.max'              => 'Nama lengkap maksimal 50 karakter',

            //     'username.required'     => 'Username wajib diisi',
            //     'username.min'          => 'Username minimal 5 karakter',
            //     'username.unique'       => 'Username ini sudah terdaftar',

            //     'email.required'        => 'Email wajib diisi',
            //     'email.email'           => 'Email tidak valid',
            //     'email.unique'          => 'Email sudah terdaftar',

            //     'password.required'     => 'Password wajib diisi',
            //     'password.min'          => 'Password minimal 6 karakter',

            //     'alamat.required'       => 'Alamat Lengkap wajib diisi',
            //     'alamat.min'            => 'Min. 10 Karakter',

            //     'telpon.required'       => 'No. Telpon wajib diisi',
            //     'telpon.min'            => 'Min. 10 Karakter',
            //     'tipe.required'         => 'Tipe wajib diisi',
            //     'status.required'       => 'Status wajib diisi',
            //     'wilayah_id.required'   => 'Wilayah wajib diisi',
            // ];

            // $validator = Validator::make($request->all(),$rules,$messages);

            // if($validator->fails()){
            //     // No Ajax

            //     // return redirect('admin/master-data/users')
            //     //             ->withErrors($validator)
            //     //             ->withInput();

            //     return response()
            //         ->json(['error' => $validator->errors()->all()])
            //         ->withErrors($validator)
            //         // ->withInput();
            //         ->withCallback($request->input('callback'));

            //     // return response()->json(['error'=>$validator->errors()->all()]);

            //     // With Ajax -->cadangan
            //     // return response()->json(['error'=>$validator]);

            // }
            /**End Contoh Custom Validation */


            /**
             * Validator ini untuk Pengalihan Otomatis
             * xhr, json
             */
            // Validator::make($request->all(), [
            //     'name'      => 'required|min:5|max:35',
            //     'username'  => 'required|min:5|unique:users',
            //     'email'     => 'required|email|unique:users,email',
            //     'telpon'    => 'required|min:10',
            //     'password'  => 'required|min:6',
            //     'tipe'      => 'required',
            //     'status'    => 'required',
            //     'alamat'    => 'required|min:10|max:255',
            //     'camat_id'  => 'required',
            //     'lurah_id'  => 'required',
            // ])->validate();


            // if ($validator->passes()) {
            //     // return $validator;
            //     return response()->json(['success'=>'Added new records.']);
            // }

            // return response()->json(['error'=>$validator->errors()->all()]);
            // return $validator;

            /**
             * Contoh Method save()
             */
            // $user = new User;
            // $user->name = ucwords(strtolower($request->name));
            // $user->username = ucwords($request->username);
            // $user->email = strtolower($request->email);
            // $user->password = Hash::make($request->password);
            // $user->email_verified_at = \Carbon\Carbon::now();
            // $user->status = ucwords($request->status);
            // $user->tipe = ucwords($request->tipe);
            // $simpan = $user->save();

            // if($simpan){
                // Session::flash('success', 'Register berhasil! Silahkan login untuk mengakses data');
                // return redirect()->route('login');
            // } else {
            //     Session::flash('errors', ['' => 'Register gagal! Silahkan ulangi beberapa saat lagi']);
            //     return redirect()->route('register');
            // }



        /**
         * Contoh Method Create
        */

        $status = ($request->status == "active") ? "True" : "False";

        if($request->password != null ) {
            $password = Hash::make($request->password);
        } else {
            $password = "123456";
        }

        #cara 2
        $user = User::create([
            'name'              => ucwords($request->name),
            'username'          => $request->username,
            'email'             => strtolower($request->email),
            'email_verified_at' => \Carbon\Carbon::now(),
            'password'          => $password,
            'alamat'            => $request->alamat,
            'telpon'            => $request->telpon,
            // 'cities_id'         => $request->cities_id,
            'status'            => $status,
            // 'tipe'              => $request->tipe,
        ]);

        // With Ajax
        return response()->json(
            [
                'success' => 'Data User berhasil di-Tambahkan',
                'data'    => $user,
            ]
        );

        // No Ajax
        // $info = [
        //     'success'   => 'Data berhasil di-Tambahkan',
        //     'data'      => $user
        // ];
        // return redirect('admin/master-data/users')->with($info);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        // return "Page SHOW";

        $where = array('id' => $id);
        $user  = User::where($where)->first();

        return Response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {

        $where = ['id' => $request->id];
        $user  = User::where($where)->first();
        return Response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        /**Contoh */
            // $rules_email = [];
            // $rules_password = [];
            // $rules_username = [];

            // $message_email = [];
            // $message_password = [];
            // $message_username = [];

            // $email_lama = $user->email;
            // $email_baru = $request->email;

            // $password_baru = $request->password;

            // $username_lama = $user->username;
            // $username_baru = $request->username;

            // // cek validasi khusus
            // if ($email_lama != $email_baru ) {
            //     $rules_email = ['email '=>'required|email|unique:user,email'];
            //     $message_email = [
            //         'email.required'        => 'Email wajib diisi',
            //         'email.email'           => 'Email tidak valid',
            //         'email.unique'          => 'Email sudah terdaftar',
            //     ];
            // }

            // if ( $password_baru != null ) {
            //     $rules_password = ['password '=> 'required|min:6'];
            //     $message_password  = [
            //         'password.required' => 'Password wajib diisi',
            //         'password.min'      => 'Password minimal 6 karakter',
            //     ];
            // }

            // if ($username_lama != $username_baru ) {
            //     $rules_username = ['username'  => 'required|min:5|unique:users'];
            //     $message_username = [
            //         'username.required'     => 'Username wajib diisi',
            //         'username.min'          => 'Username minimal 5 karakter',
            //         'username.unique'       => 'Username ini sudah terdaftar',
            //     ];
            // }

            // $rules_lainnya = [
            //     'name'      => 'required|min:5|max:35',
            //     'telpon'    => 'required|min:10',
            //     'tipe'      => 'required',
            //     'status'    => 'required',
            //     'alamat'    => 'required|min:10|max:255',
            //     'camat_id'  => 'required',
            //     'lurah_id'  => 'required',
            // ];

            // $message_lainnya = [
            //     'name.required'         => 'Nama Lengkap wajib diisi',
            //     'name.min'              => 'Nama lengkap minimal 3 karakter',
            //     'name.max'              => 'Nama lengkap maksimal 35 karakter',

            //     'alamat.required'       => 'Alamat Lengkap wajib diisi',
            //     'alamat.min'            => 'Min. 10 Karakter',

            //     'telpon.required'       => 'No. Telpon wajib diisi',
            //     'telpon.min'            => 'Min. 10 Karakter',

            //     'tipe.required'         => 'Tipe wajib diisi',
            //     'status.required'       => 'Status wajib diisi',
            //     'camat_id.required'     => 'Kecamatan wajib diisi',
            //     'lurah_id.required'     => 'Keluranan wajib diisi',
            // ];

            // $rules_group = array_merge($rules_email,$rules_password,$rules_username,$rules_lainnya);
            // $mess_group = array_merge($message_email,$message_password,$message_username,$message_lainnya);

            // Validator::make($request->all(), [
            //     'name'      => 'required|min:5|max:35',
            //     'telpon'    => 'required|min:10',
            //     'tipe'      => 'required',
            //     'status'    => 'required',
            //     'alamat'    => 'required|min:10|max:255',
            //     'camat_id'  => 'required',
            //     'lurah_id'  => 'required',

            //     // 'password'  => 'required|min:6',
            //     // 'username'  => 'required|min:10|unique:users',
            //     // 'email'     => 'required|email|unique:users,email',
            // ])->validate();

            // Validator::make($request->all(), $gabungan )->validate();

            /**Start Contoh Custom Validation */

            // $rules = [
            //     'name'      => 'required|min:5|max:35',
            //     'username'  => 'required|min:5|unique:users',
            //     'email'     => 'required|email|unique:users,email',
            //     'telpon'    => 'required|min:10',
            //     'password'  => 'required|min:6',
            //     'alamat'    => 'required|min:10',
            //     'tipe'      => 'required',
            //     'status'    => 'required',
            //     'camat_id'  => 'required',
            //     'lurah_id'  => 'required',
            // ];

            // $validator = Validator::make($request->all(),$rules_group,$mess_group);

            // return $validator;

            // if($validator->fails()){
            //     // No Ajax
            //     // return redirect('admin/master-data/users')
            //     //             ->withErrors($validator)
            //     //             ->withInput();

            //     // return response()
            //     //     ->json(['error' => $validator->errors()->all()])
            //     //     ->withCallback($request->input('callback'));

            //     return response()->json(['error'=>$validator->errors()->all()]);

            //     // With Ajax -->cadangan
            //     // return response()->json(['error'=>$validator]);
            // }

        /**End Contoh Custom Validation */

        $status = ($request->status == "active") ? "True" : "False";

        if($request->password != null ) {
            $password = Hash::make($request->password);
        } else {
            $password = $user->password;
        }

        /**
         * Password jika kosong, gak usah di update
         */

        #cara 2 - update
            // $update = User::where('id', $user->id)
            // ->update([
            //     'alamat'    => $request->alamat,
            //     'wilayah_id'=> $request->wilayah_id,
            //     'email'     => strtolower($request->email),
            //     'email_verified_at' => \Carbon\Carbon::now(),
            //     'name'      => ucwords($request->name),
            //     'status'    => $status,
            //     'tipe'      => $request->tipe,
            //     'telpon'    => $request->telpon,
            //     'username'  => $request->username,
            //     'password'  => Hash::make($password_baru)
            // ]);

        // With Ajax

        /**
         * Cara 3 - upsert
         */
        $update = User::upsert(
            [
                [
                    'id'         => $user->id,
                    'name'       => $request->name,
                    'alamat'     => $request->alamat,
                    'telpon'     => $request->telpon,
                    'wilayah_id' => $request->wilayah_id,
                    'status'     => $status,
                    'username'   => $request->username,
                    'password'   => $password,
                    'email'      => strtolower($request->email),
                    'email_verified_at' => \Carbon\Carbon::now(),

                ],

            ],
            ['id', 'telpon', 'username', 'email'],
            ['username','password','email','name','telpon','alamat','wilayah_id','tipe','status']
        );

        return response()->json(
            [
                'success' => 'Data User berhasil di-Update',
                'updated' => $update,
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return response()->json(
            [
                'success' => 'Data User berhasil di-Hapus',
                'data'    => $user,
            ]
        );
    }

     public function cekTelpon(Request $request) {

        // return response()->json($request);

        $cari = User::where('telpon', '=', $request->telpon)->exists(); // menghasilkan 1 / 0 (true/false)
        if ($cari) {
            return response()->json(false);
        } else {
            return response()->json(true);
        }
    }
}
