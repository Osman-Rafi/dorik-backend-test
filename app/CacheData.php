<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CacheData extends Model
{
    protected $fillable = ['client_ip', 'data'];
}
