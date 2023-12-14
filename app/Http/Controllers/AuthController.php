<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;

use App\Models\Usaha;
use App\Models\Akun;
use App\Models\User;
// use App\Models\Role;

class AuthController extends Controller
{
    public function showFormLogin()
    {
        if (Auth::check()) {
            // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect()->route('dashboard.index');
        } else {
            return view('ui_admin.auth.login');
        }
    }

    public function login(Request $request)
    {
        $rules = [
            // 'email'              => 'required|string|email|unique:users',
            'username'              => 'required|string',
            'password'              => 'required|string'
        ];

        $messages = [
            'username.required'     => 'Username/Email wajib diisi',
            'password.required'     => 'Password wajib diisi',
            'password.string'       => 'Password harus berupa string'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        # LAKUKAN PENGECEKAN, JIKA INPUTAN DARI USERNAME FORMATNYA ADALAH EMAIL, MAKA KITA AKAN MELAKUKAN
        # PROSES AUTHENTICATION MENGGUNAKAN EMAIL, SELAIN ITU, AKAN MENGGUNAKAN USERNAME
        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        //TAMPUNG INFORMASI LOGINNYA, DIMANA KOLOM TYPE PERTAMA BERSIFAT DINAMIS BERDASARKAN VALUE DARI PENGECEKAN DIATAS
        $login = [
            $loginType => $request->input('username'),
            'password' => $request->input('password'),
            'active'   => true
        ];

        if ( Str::contains(json_encode($request->all()), 'remember') ) {
            $auth = Auth::attempt($login, true);
        } else {
            $auth = Auth::attempt($login, false);
        }

        if (Auth::check()) {
            // true sekalian session field di users nanti bisa dipanggil via Auth
            // Login Success
            return redirect()->route('dashboard.index');
        } else { // false
            //Login Fail
            Session::flash('error', 'Username/Email, password salah atau account anda tidak active');
            return redirect()->route('login');
        }

    }

    public function showFormRegister(Request $request) {
        // return abort(503);
        return view('ui_admin.auth.register', ['tipe' => $request->tp]);
    }

    public function register(Request $request)
    {
        $usaha              = new Usaha;
        $usaha->nama        = $request->nama_usaha;
        $usaha->email       = strtolower($request->email);
        $usaha->access_key  = strtolower(Str::random(10));
        $usaha->tipe_usaha  = 1;
        $usaha->save();

        $user               = new User;
        $user->name         = ucwords(strtolower($request->nama_usaha));
        $user->username     = ucwords($request->username);
        $user->email        = strtolower($request->email);
        $user->password     = Hash::make($request->password);
        $user->usaha_id     = $usaha->id;
        $user->access_key   = $usaha->access_key;
        $user->role_id      = 1;
        $simpan             = $user->save();

        $tgl_awal = date('Y-m-d', strtotime(\Carbon\Carbon::now()));
        $durasi = 14;
        $tgl_akhir =  date('Y-m-d', strtotime($tgl_awal . ' + ' . $durasi . ' days'));

        $akun              = new Akun;
        $akun->usaha_id    = $usaha->id;
        $akun->paket_id    = 1;
        $akun->status      = "1"; //active
        $akun->biaya       = 0;
        $akun->keterangan  = "Percobaan ".$durasi." hari.";
        $akun->durasi      = $durasi;
        $akun->start_date  = $tgl_awal;
        $akun->expire_date = $tgl_akhir;
        $sukses_akun       = $akun->save();

        if($sukses_akun){
            Session::flash('success', 'Pendaftaran berhasil! Silahkan login untuk mengakses data');
            // return redirect()->route('login');
            $info = [
                'pesan' => 'success',
                'isi_pesan' => 'Pendaftaran berhasil! Silahkan login untuk mengakses data',
            ];

        } else {
            $info = [
                'pesan' => 'error',
                'isi_pesan' => 'Data User Gagal di-Simpan',
            ];
            Session::flash('errors', ['' => 'Pendaftaran gagal! Silahkan ulangi beberapa saat lagi']);
            // return redirect()->route('register');
        }
        return response()->json([
            'info' => $info,
            'user' => $user,
        ]);
    }

    public function logout()
    {
        Auth::logout(); // menghapus session yang aktif
        return redirect()->route('homepage');
        // return redirect()->route('login');
    }
}
