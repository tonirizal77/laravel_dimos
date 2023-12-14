<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Helpers\ResponseFormatter;
use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'email|required',
                'password' => 'required',
            ]);

            // mengecek credentials (login)
            $credentials = request(['email','password']);

            if(!Auth::attempt($credentials)) {
                return ResponseFormatter::error(['message' => 'Unauthorized'],
                    'Authentication Failed',500
                );
            }

            $user = User::where('email', $request->email)->first();

            //jika tidak berhasil login
            if(!Hash::check($request->password, $user->password,[])){
                throw new \Exception('Invalid Credentials');
            }

            //jika berhasil maka loginkan dan buat token
            $tokenResult = $user->createToken('authToken')->plainTextToken; // bawaan laravel

            return ResponseFormatter::success(
                [
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                    'user' => $user
                ],
                'Authenticated'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $error
                ],
                'Authentication Failed', 500
            );
        }
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

        try {
            $request->validate([
                'name'      => ['required','string','max:255'],
                'email'     => ['required','string','email', 'max:255', 'unique:users'],
                'password'  => $this->passwordRules(),
            ]);

            User::created([
                'name'              => $request->name,
                'email'             => $request->email,
                'password'          => Hash::make($request->password),
                'houseNumber'       => $request->houseNumber,
                'phoneNumber'       => $request->phoneNumber,
                'city'              => $request->city,
                'profile_photo_path'=> $request->profilePhoto,
                'roles'             => 'USER',
            ]);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('authToken')->plainTextToken;

            return ResponseFormatter::success(
                [
                    'access_token' => $tokenResult,
                    'token_type' => 'Bearer',
                    'user' => $user
                ],
                'Authenticated'
            );
        } catch (Exception $error) {
            return ResponseFormatter::error(
                [
                    'message' => 'Something went wrong',
                    'error' => $error
                ],
                'Authentication Failed',500
            );
        }
    }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function fetch(Request $request){
        Return ResponseFormatter::success(
            $request->user(), 'Data Profile User Berhasil diambil'
        );
    }

    public function updateProfile(Request $request)
    {
        $data = $request->all();
        $user = Auth::user();
        $user->update($data);
        return ResponseFormatter::success($user, 'Profile Updated');
    }

    public function updatePhoto(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|image|max:2048',
        ]);

        if ($validator->fails()){
            return ResponseFormatter::error(
                ['error' => $validator->errors()],
                'Upload Photo Gagal', 401
            );
        }

        if ($request->file('file')) {
            $file = $request->file->store('assets/user','public');

            // Proses simpan photo ke database (urlnya)
            $user = Auth::user();
            $user->profile_photo_path = $file;
            $user->update();

            return ResponseFormatter::success([$file],'Upload Photo Berhasil');

        }
    }
}

