<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        return view('admin.roles.index', compact('users', 'roles'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();

        return view('admin.roles.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'roles' => 'array',
        ]);

        // Sync roles
        $user->roles()->sync($request->roles ?? []);

        return redirect()
            ->route('admin.roles.index')
            ->with('success', 'Roles updated successfully.');
    }
}