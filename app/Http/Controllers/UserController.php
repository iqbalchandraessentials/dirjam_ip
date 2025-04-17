<?php

namespace App\Http\Controllers;

use App\Models\unit\M_UNIT;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        $unit = M_UNIT::all();
        return view('pages.masterData.users.index', compact('users', 'roles', 'unit'));
    }


    public function store(Request $request)
    {
        try {   
        $request->validate([
            'userid'     => 'required',
            'name'       => 'required',
            'email'      => 'required|email',
            'hak_akses'  => 'required',
        ]);

        User::updateOrCreate(
            ['user_id' => $request->userid],
            [
                'user_id'       => $request->userid,
                'nama_lengkap'  => $request->name,
                'email'         => $request->email,
                'role'          => $request->hak_akses,
                'dibuat_oleh'   => Session::get('user')['nama'] ?? 'SYSTEM',
            ]
        );
        
        return redirect()->route('users.index')->with('success', 'Role berhasil di-assign.');
        
        } catch (ValidationException $e) {
            return redirect()->back()->with('success', $e->errors());;
        }
    }

    public function updateRolesPermissions(Request $request, User $user)
    {
        $validated = $request->validate([
            'roles' => 'array',
            'roles.*' => 'string|exists:roles,name',
            'permissions' => 'array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);
        $user->syncRoles($validated['roles'] ?? []);
        $user->syncPermissions($validated['permissions'] ?? []);
        return redirect()->back()->with('success', 'Roles and permissions updated successfully.');
    }

    public function assignPermission(Request $request, User $user)
    {
        $request->validate(['permission' => 'required']);
        $permission = Permission::findByName($request->permission);
        $user->givePermissionTo($permission);

        return redirect()->back()->with('success', 'Permission assigned to user successfully.');
    }
    
    public function getData(Request $request, $user)
    {

        $needle = explode("|", "YWRtaW4uZXByb2NAaW5kb25lc2lhcG93ZXIuY29ycA==|NERNMW4zcHIwYyMh|a3B1cmFudXMwMS5pbmRvbmVzaWFwb3dlci5jb3Jw");
        $search = $user;

        $ldapConn = ldap_connect(base64_decode($needle[2]));
        $data = ["result" => false];

        if ($ldapConn) {
            ldap_set_option($ldapConn, LDAP_OPT_REFERRALS, 0);
            ldap_set_option($ldapConn, LDAP_OPT_PROTOCOL_VERSION, 3);

            try {
                $ldapBind = ldap_bind($ldapConn, base64_decode('aW50LmFk'), base64_decode("QnIzd01Ac3RlclNUUg=="));
            } catch (\Exception $e) {
                return response()->json($data);
            }

            if ($ldapBind) {
                $dn = "DC=indonesiapower,DC=corp";
                $filter = "(|(cn={$search}*))";
                $attributes = [
                    "postofficebox", "title", "ou", "sn", "givenname",
                    "mail", "samaccountname", "cn", "physicaldeliveryofficename",
                    "department", "company", "thumbnailphoto"
                ];


                $searchResult = ldap_search($ldapConn, $dn, $filter, $attributes);
                $entries = ldap_get_entries($ldapConn, $searchResult);

                if ($entries["count"] > 0) {
                    $i = 0;
                    for ($x = 0; $x < $entries["count"]; $x++) {
                        if (!isset($entries[$x]["givenname"][0])) {
                            continue;
                        }

                        $data["result"] = true;
                        $data[$i] = [
                            "nama" => $entries[$x]["cn"][0] ?? "",
                            "jabatan" => $entries[$x]["title"][0] ?? "",
                            "user_id" => $entries[$x]["samaccountname"][0] ?? "",
                            "mail" => $entries[$x]["mail"][0] ?? "",
                            "ou" => $entries[$x]["physicaldeliveryofficename"][0] ?? "",
                            "department" => $entries[$x]["department"][0] ?? "",
                            "company" => $entries[$x]["company"][0] ?? "",
                            "nip" => $entries[$x]["postofficebox"][0] ?? "",
                            "photo" => isset($entries[$x]["thumbnailphoto"])
                                ? 'data:image/jpeg;base64,' . base64_encode($entries[$x]["thumbnailphoto"][0])
                                : asset("img/user.png"),
                        ];
                        $i++;
                    }
                    $data["count"] = $i;
                }
            }
        }

        return response()->json($data);
    }

        // public function assignRole(Request $request, User $user)
    // {
    //     $request->validate(['role' => 'required']);
    //     $role = Role::findByName($request->role);
    //     $user->assignRole($role);
    //     return redirect()->back()->with('success', 'Role assigned to user successfully.');
    // }



    // public function update(Request $request)
    // {
    //     $validated = $request->validate([
    //         'id' => 'required|exists:users,id', // Gunakan id, bukan user_id
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email,' . $request->id,
    //         'password' => 'nullable|min:6',
    //         'unit_kd' => 'nullable|string|max:255',
    //         'user_id' => 'string|max:255',
    //     ]);
    
    //     $user = User::findOrFail($request->id); // Gunakan id untuk mencari user
    //     $user->name = $validated['name'];
    //     $user->email = $validated['email'];
    //     $user->user_id = $validated['user_id'];
    //     if ($request->password) {
    //         $user->password = Hash::make($request->password);
    //     }
    //     $user->unit_kd = $validated['unit_kd'] ?? null;
    //     $user->save();
    
    //     return redirect()->back()->with('success', 'User updated successfully.');
    // }


}
