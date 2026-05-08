<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {

        $validatedData = Validator::make($request->all(), [
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|numeric|unique:users|digits:10',
            'password' => 'required|string|min:5',
        ]);

        if ($validatedData->fails()) {
            $errors = [];

            foreach ($validatedData->errors()->toArray() as $key => $value) {
                $errors[$key] = $value[0];
            }
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $errors
            ], 422);
        }

        $data = [
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'email' => $request->email,
            'phone' => $request->phone ?? null,
            'password' => bcrypt($request->password),
        ];

        $user = User::create($data);
        // $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['status' => true], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid email or password'
            ], 401);
        }

        $user = User::where('email', $request->email)->first();

        // optional: delete old tokens
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status' => true,
            'user' => $user,
            'token' => $token
        ], 200);
    }
}
