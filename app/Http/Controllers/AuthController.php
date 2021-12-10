<?php

namespace App\Http\Controllers;

use App\RegisteredStudent;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|integer'
        ]);

        $user = User::create([
            'name' => $attr['name'],
            'password' => bcrypt($attr['password']),
            'email' => $attr['email'],
            'role' => $attr['role']
        ]);

        return $this->success([
            'token' => $user->createToken('API Token')->plainTextToken,
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }

        $user = auth()->user();

        if ($user->role === 3) {
            $registered_class = RegisteredStudent::with('user')->where('user_id', $user->id)->get();
            return $this->success([
                $registered_class,
            ]);
        } else {
            return $this->success([
                'token' => auth()->user()->createToken('API Token')->plainTextToken,
            ]);
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return [
            'message' => 'User logged out'
        ];
    }
}
