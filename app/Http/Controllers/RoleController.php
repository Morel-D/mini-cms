<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;

class RoleController extends Controller
{
        /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|exists:roles,name'
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::where('name', $request->role)->firstOrFail();

        $user->roles()->attach($role->id);

        return response()->json([
            'message' => "Role '{$role->name}' assigned to '{$user->name}' successfully."
        ]);
    }
}
