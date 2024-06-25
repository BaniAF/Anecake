<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\FirebaseServices;

class CheckFirebaseAuth
{
    protected $database;

    public function __construct() {
        $this->database = FirebaseServices::connect();
    }

    public function handle(Request $request, Closure $next)
    {
        // Ambil ID pengguna dari sesi
        
        $userId = $request->session()->get('id');

        // Jika ID pengguna tidak null, pengguna sudah terotentikasi, lanjutkan ke halaman yang diminta
        if ($userId !== null) {
            return $next($request);
        }

        // Jika ID pengguna null, pengguna belum terotentikasi, alihkan ke halaman login
        return redirect()->route('login');
    }

}
