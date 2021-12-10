<?php

namespace App\Http\Controllers;

use App\Classroom;
use App\Post;
use App\SubjectTeacher;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $invitation_code = Str::random(12);

        if ($user_role !== 1) {
            $subject_teacher = SubjectTeacher::where('user_id', auth()->user()->id)->value('subject');

            if ($subject_teacher === $attr['subject']) {

                $classroom = Classroom::create([
                    'subject' => $attr['subject'],
                    'user_id' => auth()->user()->id,
                    'invitation_code' => $invitation_code
                ]);

                return $this->success([
                    'message' => 'Classroom Created',
                    'classroom' => $classroom
                ]);
            }
            return $this->error('You\'re not allowed to make this class', 401);

        } else {
            $classroom = Classroom::create([
                'subject' => $attr['subject'],
                'user_id' => auth()->user()->id,
                'invitation_code' => $invitation_code
            ]);

            return $this->success([
                'message' => 'Classroom Created',
                'classroom' => $classroom
            ]);
        }
    }

    public function endClassroom($id)
    {
        $user_role = auth()->user()->role;
        $user_id = auth()->user()->id;
        $class = Classroom::findOrFail($id);

        if ($user_role === 1 || $user_id === $class->user_id) {
            $available_classes = Classroom::findOrFail($id);
            if ($available_classes->delete()) {
                return $this->success([
                    'message' => 'Classroom Ended'
                ]);
            }
            return $this->error('Something went wrong', 401);
        }
        return $this->error('Access denied', 401);
    }

    public function createPost(Request $request)
    {
        $attr = $request->validate([
            'type' => 'required|string|in:assignment,exam',
            'deadline' => 'required|date_format:Y-m-d H:i:s',
            'attachment' => 'mimes:pdf,image',
            'class_id' => 'required|integer'
        ]);

        $filepath = Storage::disk('public')->put('posts', $attr['attachment']);
        $post = Post::create([
            'type' => $attr['type'],
            'deadline' => $attr['deadline'],
            'user_id' => auth()->user()->id,
            'attachment' => $filepath,
            'class_id' => $attr['class_id']
        ]);

        return $this->success([
            'message' => 'Post Created',
            'classroom' => $post
        ]);
    }
}
