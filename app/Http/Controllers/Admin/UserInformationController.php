<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserInformationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //check if user is super admin
        if (Auth::user()->role == 'superadmin') {
        $user = User::with('items')->find($id);
        return view('admin.dashboard.userinfo', compact('user'));
            } else {
            $user = User::with('items')->find(Auth::id());
            return view('admin.useronly.userinfo', compact('user'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //check if user is super admin
        if (Auth::user()->role == 'superadmin') {
            $user = User::find($id);
            return view('admin.dashboard.edit_userinfo', compact('user'));
        } else {
            $user = User::find(Auth::id());
            return view('admin.useronly.edit_userinfo', compact('user'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
        ]);

        // If validation fails, redirect back with errors
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            // Find the user by ID
            $user = User::findOrFail($id);

            // Update user's name and email
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();


            // Redirect to the user's view page with success message and authenticated user's data
            return redirect()->route('user.view', ['id' => $user->id])->with([
                'success' => 'User information updated successfully.',
            ]);
        } catch (\Exception $e) {
            // Redirect back with error message if an exception occurs
            return redirect()->back()->with('error', 'Failed to update user information. Please try again.');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete user
        $user = User::find($id);
        $user->delete();
        return redirect()->route('users');
    }
}
