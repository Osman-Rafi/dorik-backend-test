<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Classroom extends Model
{
    protected $fillable = ['subject', 'user_id', 'invitation_code'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
