<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['Users' => User::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:super_admin,admin_icodsa,admin_icicyta',
        ]);

        $user = User::create($validated);

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::where('id', $id)->first();
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }
        return response()->json($user, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
    
        $validatedData = $request->validate([
            'username' => "required|string|unique:users,username,{$user->id}",
            'email' => "required|email|unique:users,email,{$user->id}",
            'role' => 'required|in:super_admin,admin_icodsa,admin_icicyta',
        ]);
    
        $user->update($validatedData);
    
        return response()->json(['message' => 'User updated successfully', 'user' => $user], 200);
    }
    
    /**
     * Password update for a specified resource in storage.
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);
    
        $user = User::findOrFail(Auth::id());
    
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json(['message' => 'Old password is incorrect'], 400);
        }
    
        $user->update(['password' => Hash::make($request->new_password)]);
    
        return response()->json(['message' => 'Password updated successfully'], 200);
    }

    /**
     * Password update for a all resource in storage.
     */
    public function updateUserPassword(Request $request, string $id)
    {
        // Pastikan hanya super_admin yang bisa mengubah password user lain
        if (Auth::user()->role !== 'super_admin') {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $user = User::findOrFail($id);

        $request->validate([
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user->update(['password' => Hash::make($request->new_password)]);

        return response()->json(['message' => 'Password updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $User = User::find($id);
        if (!$User) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $User->delete();
        return response()->json(['message' => 'User deleted'], 200);
    }

    /**
     * Returns the specified resource from storage.
     */
    public function restore(string $id)
    {
        $User = User::onlyTrashed()->find($id);
        if (!$User) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $User->restore();
        return response()->json(['message' => 'User restored'], 200);
    }

    /**
     * Permanently remove the specified resource from storage.
     */
    public function forceDelete(string $id)
    {
        $User = User::onlyTrashed()->find($id);
        if (!$User) {
            return response()->json(['message' => 'User not found'], 404);
        }
    
        $User->forceDelete();
        return response()->json(['message' => 'User permanently deleted'], 200);
    }
}
