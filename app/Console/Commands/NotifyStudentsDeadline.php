<?php

namespace App\Console\Commands;

use App\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;

class NotifyStudentsDeadline extends Command
{
    protected $signature = 'students:notify';

    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Post::with([
            'classroom' => function ($q1) {
                $q1->with([
                    'registeredStudents' => function ($q2) {
                        $q2->with([
                            'users' => function ($user) {
                                if ($user->deadline_date->diff(Carbon::now())->subMinute(60))
                                    $user->notify("You have a exam deadline");
                            }
                        ]);
                    }
                ]);
            }
        ]);
    }
}
