<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Traits\ApiResponser;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Models\User;
use App\Models\Usaha;
use App\Models\Akun;
// use App\Models\Role;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {


        try {
            $request->validate([
                'name'      => ['required','string','max:255'],
                'email'     => ['required','string','email', 'max:255', 'unique:users'],
                'password'  => ['required','string','min:6'],
            ]);

            $user = User::create([
                'name'      => $request->name,
                'username'  => $request->username,
                'email'     => $request->email,
                'password'  => Hash::make($request->password),
                'alamat'    => $request->alamat,
                'kota'      => $request->kota,
                'telpon'    => $request->telpon,
                'tipe'      => $request->tipe,
            ]);

            // return response()->json($request);

            $user = User::where('email', $request->email)->first();

            $tokenResult = $user->createToken('API Token')->plainTextToken;

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

            //jika tidak berhasil login
            $user = User::where('email', $request->email)->first();
            if(!Hash::check($request->password, $user->password,[])){
                throw new \Exception('Invalid Credentials');
            }

            //jika berhasil login
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
                'Authentication Failed', 500
            );
        }
    }

    // public function logout()
    // {
    //     auth()->user()->tokens()->delete();
    //     return [
    //         'message' => 'Tokens Revoked'
    //     ];
    // }

    public function logout(Request $request)
    {
        $token = $request->user()->currentAccessToken()->delete();
        return ResponseFormatter::success($token, 'Token Revoked');
    }

    public function fetch(Request $request){
        Return ResponseFormatter::success(
            $request->user(),'Data Profile User Berhasil diambil'
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
