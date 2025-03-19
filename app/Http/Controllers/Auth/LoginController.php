<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use LdapRecord\Container;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;
use LdapRecord\Auth\BindException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'password' => 'required',
        ]);
    
        $user_id = $request->user_id;
        $password = $request->password;
    
        if (Auth::attempt(['user_id' => $user_id, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        } else {
            return back()->with('login_error', 'Username atau password salah!');
        }
    
        // // 2️⃣ Coba Autentikasi via LDAP tanpa menyimpan ke database
        try {
            $connection = Container::getConnection();
            $ldapBind = $connection->auth()->attempt("$user_id@indonesiapower.corp", $password);
    
            if ($ldapBind) {
                // Ambil data user dari LDAP
                $ldapUser = LdapUser::where('samaccountname', $user_id)->first();
    
                if (!$ldapUser) {
                    return back()->with('error', 'User tidak ditemukan di LDAP.');
                }
    
                // Simpan data user ke session Laravel
                Session::put('user', [
                    'nama'        => $ldapUser->cn[0] ?? $user_id,
                    'jabatan'     => $ldapUser->title[0] ?? '',
                    'user_id'     => $ldapUser->samaccountname[0] ?? $user_id,
                    'username'    => $ldapUser->samaccountname[0] ?? $user_id,
                    'email'       => $ldapUser->mail[0] ?? "$user_id@indonesiapower.corp",
                    'ou'          => $ldapUser->physicaldeliveryofficename[0] ?? '',
                    'department'  => $ldapUser->department[0] ?? '',
                    'company'     => $ldapUser->company[0] ?? '',
                    'nip'         => $ldapUser->postofficebox[0] ?? '',
                    'photo'       => isset($ldapUser->thumbnailphoto) ? 
                                    'data:image/jpeg;base64,' . base64_encode($ldapUser->thumbnailphoto[0]) : asset('assets/images/user.png'),
                ]);

                // Tambahkan di sini
                // $userSession = session('user');
                // dd($userSession);  

                // redirect sebaiknya di letakkan setelah dd
                return redirect()->intended(route('home'));
            }
        } catch (BindException $e) {
            return back()->with('error', 'Username atau password salah!');
        }     
    }

    public function logout()
    {
        Session::forget('user'); // Hapus session user
        Auth::logout();
        return redirect(route('login'));
    }
}

// Cara Menggunakan Data User dari Session
// @if(Session::has('user'))
//     <p>Halo, {{ Session::get('user')['nama'] }}!</p>
//     <p>Email: {{ Session::get('user')['email'] }}</p>
//     <img src="{{ Session::get('user')['photo'] }}" alt="User Photo">
// @endif