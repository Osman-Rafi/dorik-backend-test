<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Classroom extends Model
{
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['subject', 'user_id', 'invitation_code'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
