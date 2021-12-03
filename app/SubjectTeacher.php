<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectTeacher extends Model
{
    protected $fillable = [
        'user_id', 'subject'
    ];
}
