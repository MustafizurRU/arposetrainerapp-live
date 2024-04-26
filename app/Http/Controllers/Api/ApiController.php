<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                $user = Auth::user();
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                    'status' => 'success',
                    'message' => 'Login Successfully!',
                    'token' => $token
                ]);
            }
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials'
            ], 401);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);

        }
    }
    //register
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6'
            ]);
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);
            return response()->json([
                'status' => 'success',
                'data' => $user
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
    //items
    public function allItems()
    {
        try {
            $items = User::with('items')->get();
            return response()->json([
                'status' => 'success',
                'data' => $items
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
    //post items
    public function createItem(Request $request)
    {
        try {
            $request->validate([
                'level_name' => 'required',
                'level_wise_score' => 'required',
                'level_performance' => 'required',
                'pose_image_url' => 'required'
            ]);
            $item = new Item();
            $item->user_id = Auth::id();
            $item->level_name = $request->level_name;
            $item->level_wise_score = $request->level_wise_score;
            $item->level_performance = $request->level_performance;
            $item->pose_image_url = $request->pose_image_url;
            $item->save();
            return response()->json([
                'status' => 'success',
                'data' => $item
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => 'error',
                'message' => $th->getMessage()
            ], 500);
        }
    }
}
