<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        $permissions = Permission::all();

        return view('pages.users.index', compact('users', 'roles', 'permissions'));
    }

    public function assignRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required']);
        $role = Role::findByName($request->role);
        $user->assignRole($role);

        return redirect()->back()->with('success', 'Role assigned to user successfully.');
    }

    public function assignPermission(Request $request, User $user)
    {
        $request->validate(['permission' => 'required']);
        $permission = Permission::findByName($request->permission);
        $user->givePermissionTo($permission);

        return redirect()->back()->with('success', 'Permission assigned to user successfully.');
    }
}
