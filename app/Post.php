<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['type', 'deadline', 'user_id', 'attachment', 'class_id'];
    protected $dates = ['deadline'];
}
