<?php

namespace App\Http\Controllers;

use App\Mail\TeacherCreated;
use App\SubjectTeacher;
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
            'subject' => 'required|string|max:60'
        ]);

        $generated_password = Str::random(8);

        $user = User::create([
            'name' => $attr['name'],
            'email' => $attr['email'],
            'password' => bcrypt($generated_password),
            'role' => 2
        ]);

        SubjectTeacher::create([
            'user_id' => $user->id,
            'subject' => $attr['subject']
        ]);

        Mail::to($attr['email'])->send(new TeacherCreated($attr, $generated_password));

        return $this->success([
            'message' => 'Teacher Created',
        ]);
    }
}
