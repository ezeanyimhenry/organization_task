<?php

namespace App\Http\Controllers;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganisationController extends Controller
{
    public function index()
    {
        // Fetch the authenticated user
        $user = Auth::user();

        if (!($user instanceof User)) {
            return response(['message' => 'User not found'], 404);
        }

        // Get organisations user belongs to or created
        $organisations = $user->organisations()->get();

        return response()->json([
            'status' => 'success',
            'message' => 'Organisations fetched successfully',
            'data' => [
                'organisations' => $organisations,
            ],
        ], 200);
    }

    public function show($orgId)
    {
        // Fetch the authenticated user
        $user = Auth::user();

        // Find organisation
        $organisation = Organisation::find($orgId);

        if (!$organisation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Organisation not found',
            ], 404);
        }

        // Check if the user belongs to this organisation
        if ($organisation->users()->where('user_id', $user->id)->exists()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Organisation fetched successfully',
                'data' => $organisation,
            ], 200);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 403);
        }
    }

    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'name' => 'required|string|unique:organisations',
            'description' => 'string|nullable',
        ]);

        // Create new organisation
        $organisation = Organisation::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Attach the current user to the newly created organisation
        $user = Auth::user();
        $organisation->users()->attach($user);

        return response()->json([
            'status' => 'success',
            'message' => 'Organisation created successfully',
            'data' => $organisation,
        ], 201);
    }

    public function addUser(Request $request, $orgId)
    {
        // Validate request data
        $request->validate([
            'userId' => 'required|string',
        ]);

        // Find organisation
        $organisation = Organisation::find($orgId);

        if (!$organisation) {
            return response()->json([
                'status' => 'error',
                'message' => 'Organisation not found',
            ], 404);
        }

        // Attach user to organisation
        $user = User::find($request->userId);

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found',
            ], 404);
        }

        $organisation->users()->attach($user);

        return response()->json([
            'status' => 'success',
            'message' => 'User added to organisation successfully',
        ], 200);
    }
}
