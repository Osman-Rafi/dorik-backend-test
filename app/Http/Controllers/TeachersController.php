<?php

namespace App\Http\Controllers;

use App\Traits\AuthorizationHelpers;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Auth;

class TeachersController extends Controller
{
    use AuthorizationHelpers;

    public function __construct()
    {
        $this->middleware('adminOnly');
    }

    public function createTeacher()
    {
        return 'data retrived';
    }
}
