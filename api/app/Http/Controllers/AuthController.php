<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Models\Wishlist;
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

        $user = User::where(['email' => $request->email, 'status' => 1])->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Your account is inactive. Please contact support.'
            ], 403);
        }

        // optional: delete old tokens
        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;
        $address = Address::where(['user_id' => $user->id, 'is_default' => 1])->first();
        $cartItems = Cart::where('u_id', $user->id)->get();

        return response()->json([
            'status' => true,
            'user' => $user,
            'token' => $token,
            'address' => $address,
            'cartdata' => $cartItems,
            'stats' => [
                'orders' => Order::where('user_id', $user->id)->count(),
                'wishlist' => Wishlist::where('u_id', $user->id)->count(),
            ],
        ], 200);
    }
}
