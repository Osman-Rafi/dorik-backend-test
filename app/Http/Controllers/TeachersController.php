<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\SubjectTeacher;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TeachersController extends Controller
{

    use ApiResponser;

    public function __construct()
    {
        $this->middleware('adminAndTeacherOnly');
    }

    public function createClassroom(Request $request)
    {
        $attr = $request->validate([
            'subject' => 'required|string|max:60'
        ]);

        $user_role = auth()->user()->role;

        if ($user_role !== 1) {
            $subject_teacher = SubjectTeacher::where('user_id', auth()->user()->id)->value('subject');

            if ($subject_teacher === $attr['subject']) {
                $invitation_code = Str::random(12);

                $classroom = Classroom::create([
                    'subject' => $attr['subject'],
                    'user_id' => auth()->user()->id,
                    'invitation_code' => $invitation_code
                ]);

                return $this->success([
                    'message' => 'Teacher Created',
                    'classroom' => $classroom
                ]);
            }

            return $this->error('You\'re not allowed to make this class',401);
        }

    }
}
