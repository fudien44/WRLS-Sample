<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    /**
     * Display a listing of unverified users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch users who have not verified their email yet
        $users = User::whereNull('email_verified_at')->get();
        return view('admin.index', compact('users'));
    }

    /**
     * Verify the user and assign a role.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $userId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verifyUser(Request $request, $userId)
    {
        // Validate the incoming request
        $request->validate([
            'role' => 'required|exists:roles,name',
        ]);

        $user = User::findOrFail($userId);

        // Mark the user's email as verified
        $user->email_verified_at = now();
        $user->save();

        // Assign the role to the user
        $role = Role::findByName($request->role);
        $user->assignRole($role);

        return redirect()->route('admin.index')->with('success', 'User verified and role assigned.');
    }
}
