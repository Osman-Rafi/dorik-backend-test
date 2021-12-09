<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegisteredStudent extends Model
{
    protected $fillable = ['school_id','user_id'];
}
