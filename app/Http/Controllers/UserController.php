<?php

namespace App\Http\Controllers;

use App\Models\unit\M_UNIT;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
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

    public function assignRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required']);
        $role = Role::findByName($request->role);
        $user->assignRole($role);
        return redirect()->back()->with('success', 'Role assigned to user successfully.');
    }

    public function store(Request $request)
    {
        
        try {   
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
                'unit_kd' => 'required|string|max:255',
                'user_id' => 'required|string|unique:users,user_id',
            ]);
             User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'unit_kd' => $validated['unit_kd'],
                'user_id' => $validated['user_id'],
            ]);

            return redirect()->back()->with('success', 'Data berhasil ditambahkan.');;
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

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:users,id', // Gunakan id, bukan user_id
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => 'nullable|min:6',
            'unit_kd' => 'nullable|string|max:255',
            'user_id' => 'string|max:255',
        ]);
    
        $user = User::findOrFail($request->id); // Gunakan id untuk mencari user
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->user_id = $validated['user_id'];
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->unit_kd = $validated['unit_kd'] ?? null;
        $user->save();
    
        return redirect()->back()->with('success', 'User updated successfully.');
    }
    
}
