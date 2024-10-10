<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL; // For generating verification URL
use Illuminate\Auth\Notifications\VerifyEmail; // For email verification notification

class RoleController extends Controller
{
    public function index()
    {
        $user = User::with('role')->get(); // Ensure the relationship is eagerly loaded
        $roles = Role::all();
        return view('roles.index', compact('user', 'roles'));
    }

    public function join()
    {
        $user = User::join('users', 'users.role_id', '=', 'roles.role_id')  
        ->get(['roles.rolename']);

        return view('roles.index', compact('userRoles'));
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'lname' => 'required|string|max:255',
            'fname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'contactno' => 'required|string|max:255',
            'role' => 'required|exists:role,role_id',
            'password' => 'required|string|min:8',
        ]);

        $user = new User();
        $user->lname = $request->lname;
        $user->fname = $request->fname;
        $user->email = $request->email;
        $user->contactno = $request->contactno;
        $user->role_id = $request->role;
        $user->password = bcrypt($request->password);
        $user->save();

        $user->markEmailAsVerified();

        return redirect()->route('roles.index')->with('success', 'User created successfully.');
    }

    public function edit($user_id)
    {
        $user = User::find($user_id);

        if (!$user) {
            return response()->json(['message' => 'User  not found'], 404);
        }

        return view('roles.edit', compact('userRole'));
    }

    public function update(Request $request, $user_id)
    {
        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user_id . ',user_id',
            'contactno' => 'required|string|max:15',
            'role' => 'required|exists:role,role_id',
            'password' => 'nullable|string|min:6'
        ]);

        $user = User::findOrFail($user_id);
        
        $user->fname = $validated['fname'];
        $user->lname = $validated['lname'];
        $user->email = $validated['email'];
        $user->contactno = $validated['contactno'];
        $user->role_id = $validated['role'];
        
        if (!empty($validated['password'])) {
            $user->password = bcrypt($validated['password']);
        }

        $user->save();

        return redirect()->route('roles.index')->with('success', 'User updated successfully');
    }

    public function changePassword(Request $request)
{
    $validated = $request->validate([
        'user_id' => 'required|exists:users,user_id',
        'newPassword' => 'required|string|min:6|confirmed'
    ]);

    $user = User::findOrFail($validated['user_id']);

    // Update the password
    $user->password = bcrypt($validated['newPassword']);
    $user->save();

    return redirect()->route('roles.index')->with('success', 'Password successfully updated');
}
   
    public function show($user_id)
    {
        $user = User::find($user_id);
        if (!$user){
            return redirect()->route('roles.index')->with('error', 'User not found.');
        }
        
        return view('roles.index', compact('user'));
    }

    public function roles()
    {
        $roles = Role::pluck('rolename', 'role_id'); 
        return view('roles.index', compact('roles'));
    }

    public function destroy($user_id)
    {
        $user = User::findOrFail($user_id);
        $user->delete();

        return redirect()->route('roles.index')->with('success', 'User deleted successfully.');
    }
}
