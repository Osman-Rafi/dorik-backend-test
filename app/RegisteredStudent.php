<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisteredStudent extends Model
{
    protected $fillable = ['school_id', 'user_id', 'class_id'];

    public function classroom()
    {
        return $this->belongsTo(Classroom::class,'class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
