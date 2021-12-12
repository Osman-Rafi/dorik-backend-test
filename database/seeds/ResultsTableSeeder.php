<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResultsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('results')->insert([
            'student_id' => 4,
            'class_id' => 1,
            'total_mark' => 100,
            'attained_mark' => 80,
        ]);

        DB::table('results')->insert([
            'student_id' => 4,
            'class_id' => 1,
            'total_mark' => 100,
            'attained_mark' => 70,
        ]);

    }
}
