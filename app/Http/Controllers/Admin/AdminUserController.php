<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function index()
    {
        $viewData = [
            'title' => 'Admin User Management',
            'users' => User::paginate(10),
        ];
        return view('admin.user.index')->with("viewData", $viewData);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,client',
            'is_super_admin' => 'boolean',
            'balance' => 'nullable|integer|min:0',
        ]);

        $role = $request->input('role');
        $isSuperAdmin = $request->has('is_super_admin') ? $request->boolean('is_super_admin') : false;
        if ($isSuperAdmin) {
            $role = 'admin';
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => $role,
            'is_super_admin' => $isSuperAdmin,
            'balance' => $request->input('balance', 0),
        ]);

        return back()->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        $viewData = [];
        $user = User::findOrFail($id);
        $viewData["title"] = "Admin Page - Edit User - Online Store";
        $viewData['user'] = $user;
        return view('admin.user.edit')->with("viewData", $viewData);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin,client',
            'is_super_admin' => 'boolean',
            'balance' => 'nullable|integer|min:0',
        ]);

        $user = User::findOrFail($id);
        $originalIsSuperAdmin = $user->is_super_admin;
        $superAdminCount = User::where('is_super_admin', true)->count();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }
        $role = $request->input('role');
        $isSuperAdmin = $request->boolean('is_super_admin');

        // Prevent demoting the last super admin
        if ($originalIsSuperAdmin && !$isSuperAdmin && $superAdminCount <= 1) {
            return back()->with('error', 'Cannot remove super admin status from the last super admin.');
        }

        if ($isSuperAdmin) {
            $role = 'admin';
        }
        $user->role = $role;
        $user->is_super_admin = $isSuperAdmin;
        $user->balance = $request->input('balance');
        $user->save();

        return redirect()->route('admin.user.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if (Auth::user()->id == $user->id && $user->is_super_admin) {
            return back()->with('error', 'You cannot delete your own super admin account.');
        }
        // Check if it's the last super admin
        $superAdminCount = User::where('is_super_admin', true)->count();
        if ($user->getIsSuperAdmin() && $superAdminCount <= 1) {
            return back()->with('error', 'Cannot delete the last super admin.');
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
