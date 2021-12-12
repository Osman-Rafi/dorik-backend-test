<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classrooms')->insert([
            'user_id' => 1,
            'subject' => 'bangla',
            'invitation_code' => 'ads8ug94',
        ]);

        DB::table('classrooms')->insert([
            'user_id' => 1,
            'subject' => 'english',
            'invitation_code' => 'ioauhe87',
        ]);

    }
}
