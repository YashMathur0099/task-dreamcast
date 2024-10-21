<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function userLists(Request $request)
    {
        $users = User::with('roleData')->get();

        $response = [
            'success' => true,
            'data' => $users,
            'message' => "User data get successfully",
        ];
        return response()->json($response, 200);
    }

    public function addUser(Request $request)
    {
        \Log::info($request->all());
        // Define validation rules
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'phone' => ['required', 'regex:/^[6-9]\d{9}$/'],
            'description' => 'required|string|max:1000',
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'role_id' => 'required',
        ];

        // Validate the incoming request
        $validator = Validator::make($request->all(), $rules);

        // If validation fails, return the errors
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        // Handle profile picture upload if present
        $profilePath = null;
        if ($request->hasFile('profile')) {
            $profilePath = $request->file('profile')->store('profiles', 'public');
        }

        // Create a new user with the validated data
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'role_id' => $request->input('role_id'),
            'description' => $request->input('description'),
            'profile' => $profilePath,
            'password' => \Hash::make('pass@1234'),
        ]);

        // Return success response
        return response()->json([
            'message' => 'User created successfully!',
            'user' => $user,
        ], 201);
    }
}
