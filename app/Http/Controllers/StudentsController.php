<?php

namespace App\Http\Controllers;

use App\CacheData;
use App\Classroom;
use App\RegisteredStudent;
use App\Traits\ApiResponser;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        $if_user_exits = DB::table('users')->where('email', $attr['email'])->exists();

        if (!$if_user_exits) {
            $user = User::create([
                'name' => $attr['name'],
                'email' => $attr['email'],
                'password' => bcrypt($attr['password']),
                'role' => 3
            ]);
        } else {
            $user = User::where('email', $attr['email'])->first();
        }
        RegisteredStudent::create([
            'school_id' => $attr['school_id'],
            'user_id' => $user->id,
            'class_id' => $class_id
        ]);

        return $this->success([
            'success' => 'Student Registered Successfully !'
        ]);
    }

    public function seeUpcomingPosts()
    {
        $user = auth()->user();

        $registered_classes = RegisteredStudent::select('id','school_id','class_id')->with([
            'classroom' => function ($query) {
                $query->select('id', 'subject')->with([
                    'posts' => function ($q) {
                        $q->select('id', 'type', 'attachment', 'deadline', 'class_id');
                    }
                ]);
            }
        ])->where('user_id', $user->id)->get();

        return $registered_classes;
    }


}
