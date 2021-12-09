<?php

namespace App\Http\Controllers;

use App\CacheData;
use App\Classroom;
use App\RegisteredStudent;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;

class StudentsController extends Controller
{
    use ApiResponser;

    public function registerForClassStep1(Request $request)
    {
        $attr = $request->validate([
            'invitation_code' => 'string|required',
        ]);

        $user_ip = $request->ip();

        CacheData::create([
            'client_ip' => $user_ip,
            'data' => $attr['invitation_code']
        ]);

        return $this->success([
            'success' => 'Go for the second step'
        ]);
    }

    public function registerForClassStep2(Request $request)
    {
        $user_ip = $request->ip();
        $cached_invitation_code = CacheData::where('client_ip', $user_ip)->orderBy('created_at', 'desc')->first()->data;
        $class_id = Classroom::where('invitation_code', $cached_invitation_code)->first()->id;

        $attr = $request->validate([
            'name' => 'string|required|max:60',
            'email' => 'email|required',
            'school_id' => 'integer|required',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'name' => $attr['name'],
            'email' => $attr['email'],
            'password' => bcrypt($attr['password']),
            'role' => 3
        ]);

        $registered_student = RegisteredStudent::create([
            'school_id' => $attr['school_id'],
            'user_id' => $user->id
        ]);


    }


}
