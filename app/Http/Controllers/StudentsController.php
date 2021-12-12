<?php

namespace App\Http\Controllers;

use App\CacheData;
use App\Classroom;
use App\Post;
use App\RegisteredStudent;
use App\StudentSubmission;
use App\Traits\ApiResponser;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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

        $registered_classes = RegisteredStudent::select('id', 'school_id', 'class_id')->with([
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

    public function submitAssignmentAnswers(Request $request)
    {
        $attr = $request->validate([
            'post_id' => 'required',
            'attachment' => 'required| mimes:pdf,image'
        ]);

        $post = Post::where('id', $attr['post_id'])->first();
        $post_deadline = Carbon::parse($post->deadline);
        $current_time = Carbon::now();

        if ($current_time < $post_deadline) {
            $class = Classroom::where('id', $post['class_id'])->first();

            if ($class) {
                $filepath = Storage::disk('public')->put('posts', $attr['attachment']);

                $studentSubmission = StudentSubmission::create([
                    'post_id' => $attr['post_id'],
                    'student_id' => auth()->user()->id,
                    'attachment' => $filepath
                ]);

                return $this->success([
                    'message' => 'File Submitted',
                    'classroom' => $studentSubmission
                ]);
            } else {
                return $this->error('The class has been ended', 200);
            }


        } else {
            return $this->error('The deadline is over', 200);
        }


    }


}
