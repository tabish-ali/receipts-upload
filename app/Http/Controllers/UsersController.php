<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function profileView(Request $request)
    {
        return view('dashboard.profile');
    }

    public function updateProfile(Request $request)
    {
        $account = (object)$request->account;

        if (Auth::user()) {
            $user = User::find(Auth::user()->id);
            $user->email = $account->email;
            $user->password = Hash::make($account->password);
            $user->username = $account->username;
            $user->save();
            return response()->json(['message' => 'success'], 200);
        } else {
            return response()->json(['message' => 'failed'], 401);
        }
    }
}
