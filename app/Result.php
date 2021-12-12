<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    public function classrooms()
    {
        return $this->belongsTo(Classroom::class,'class_id');
    }
}
