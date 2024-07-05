<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function show($id)
    {
        // Fetch the authenticated user
        $user = Auth::user();

        if (!($user instanceof User)) {
            return response(['message' => 'User not found'], 404);
        }
        
        // Check if the user can access their own record or a record in an organisation they belong to or created
        if ($user->id == $id || $user->organisations()->where('id', $id)->exists()) {
            return response()->json([
                'status' => 'success',
                'message' => 'User record fetched successfully',
                'data' => [
                    'userId' => $user->id,
                    'firstName' => $user->firstName,
                    'lastName' => $user->lastName,
                    'email' => $user->email,
                    'phone' => $user->phone,
                ],
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }
    }
}
