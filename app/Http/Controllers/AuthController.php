<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\FirebaseServices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    protected $database;
    public function render()
    {
        return view ('auth.login');
    }


    public function __construct() {
        $this->database = FirebaseServices::connect();
    }

    public function login(Request $request)
    {
        // Mendapatkan username dan password dari request
        $username = $request->input('email');
        $password = $request->input('password');
        
        // Verifikasi username dan password dengan data di Firebase
        $user = $this->database->getReference('users')
                                ->orderByChild('email')
                                ->equalTo($username)
                                ->getValue();

        // Jika tidak ada data pengguna yang cocok
        if (!$user) {
            alert()->error('Gagal', 'Data Pengguna Tidak Ditemukan');
            return redirect('/login');
        }

        // Mendapatkan password yang disimpan di database
        $storedPassword = reset($user)['password'];
        // Mendapatkan level pengguna
        $userLevel = reset($user)['role'];
        // Memeriksa apakah password yang dimasukkan cocok dengan yang disimpan di database
        if ($password === $storedPassword) {
            // Memeriksa apakah pengguna memiliki level admin
            if ($userLevel === 'admin') {
                // dd("Masuk Sini");
                // Simpan informasi pengguna ke sesi
                $userId = key($user); 
                Session::put('id', $userId);

                // Redirect ke dashboard atau halaman lainnya
                return redirect()->route('admin.dashboard');
            } else if ($userLevel === 'owner'){
                $userId = key($user); 
                Session::put('id', $userId);

                // Redirect ke dashboard atau halaman lainnya
                return redirect()->route('owner.dashboard');
            }
            else {
                // Jika pengguna bukan admin, kembalikan dengan pesan error
                alert()->error('Gagal','Hanya admin yang diizinkan untuk masuk');
                return redirect()->back();
            }
        } else {
            // Jika password tidak cocok, kembalikan dengan pesan error
            alert()->error('Gagal','Username atau Password Salah.');
                return redirect()->back();
        }
    }


    public function logout()
    {
        // Melakukan logout pada pengguna
        Auth::logout();
        
        // Mengosongkan semua data sesi
        Session::flush();
        
        // Mengalihkan pengguna ke halaman login
        return redirect()->route('login');
    }
}
