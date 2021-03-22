<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegistrationController extends Controller
{
    public function index() {
        return view('auth.register');
    }

    public function register(Request $request) {
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password')); //bcrypt
        $userRole = Role::getUser();
        //$user->role_id = $userRole->id;
        $user->role()->associate($userRole);
        $user->save();

        Auth::login($user);
        return redirect()->route('profile.index');
    }
}
