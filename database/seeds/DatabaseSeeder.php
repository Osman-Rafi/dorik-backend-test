<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(ClassTableSeeder::class);
        $this->call(ResultsTableSeeder::class);
    }
}
