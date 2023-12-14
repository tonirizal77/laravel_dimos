<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Usaha;

class CekStatusToko
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string $status)
    {
        // $toko_user = Usaha::where('id', auth()->user()->usaha_id)->first();
        $toko_user = Usaha::where('id', Auth::user()->usaha_id)->first();
        if ($toko_user == null) {
            $status_toko = 0;
        } else {
            $status_toko = 1;
        }
        // dd($status_toko);

        if ($status != $status_toko) {
            return abort(403,'Anda tidak punya akses karena Status Toko Anda saat ini Tidak Aktif');
        }

        return $next($request);
    }
}
