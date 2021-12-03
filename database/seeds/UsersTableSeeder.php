<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Shakib Al Hasan',
            'email' => 'admin@email.com',
            'role' => 1,
            'password' => Hash::make('password')
        ]);

        DB::table('users')->insert([
            'name' => 'Cristiano Ronaldo',
            'email' => 'teacher@email.com',
            'role' => 2,
            'password' => Hash::make('password')
        ]);

        DB::table('users')->insert([
            'name' => 'Tamim Iqbal',
            'email' => 'teacher2@email.com',
            'role' => 2,
            'password' => Hash::make('password')
        ]);

        DB::table('users')->insert([
            'name' => 'Leonel Messi',
            'email' => 'student@email.com',
            'role' => 1,
            'password' => Hash::make('password')
        ]);
    }
}
