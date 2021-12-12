<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentSubmission extends Model
{
    protected $fillable = ['student_id', 'post_id', 'attachment'];
}
