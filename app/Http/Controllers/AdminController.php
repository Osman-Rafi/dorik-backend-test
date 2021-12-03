<?php

namespace App\Http\Controllers;

use App\Mail\TeacherCreated;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('adminOnly');
    }

    public function createTeacher(Request $request)
    {
        $attr = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users,email',
        ]);

        $generated_password = Str::random(8);


        User::create([
            'name' => $attr['name'],
            'email' => $attr['email'],
            'password' => bcrypt($generated_password),
            'role' => 2
        ]);

        Mail::to($attr['email'])->send(new TeacherCreated($attr, $generated_password));

        return $this->success([
            'message' => 'Teacher Created',
        ]);
    }
}
