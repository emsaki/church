<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    /** LIST USERS */
    public function index()
    {
        $users = User::with('roles')->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    /** CREATE USER FORM */
    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }

    /** STORE NEW USER */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'phone'    => 'nullable|string|max:20',
            'password' => 'required|min:6',
            'role_id'  => 'nullable|exists:roles,id'
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'phone'    => $data['phone'],
            'password' => bcrypt($data['password']),
        ]);

        $user->roles()->sync([$request->role_id]);
        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /** EDIT USER FORM */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /** UPDATE USER */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name'  => 'required|string',
            'email' => "required|email|unique:users,email,$user->id",
            'phone' => 'nullable|string',
            'role_id' => 'nullable|exists:roles,id'
        ]);

        $user->update($data);
        $user->roles()->sync([$request->role_id]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /** ACTIVATE/DEACTIVATE */
    public function toggleStatus(User $user)
    {
        $user->active = !$user->active;
        $user->save();

        return back()->with('success', 'User status updated.');
    }

    /** RESET PASSWORD */
    public function resetPassword(User $user)
    {
        $newPass = 'Pass@' . rand(1000, 9999);
        $user->update(['password' => bcrypt($newPass)]);

        return back()->with('success', "New password: {$newPass}");
    }

    /** DELETE USER */
    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success', 'User removed successfully.');
    }
}