<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name'=>'Admin',
             'email'=>'SuperZzzZAngel@gmail.com',
             'password'=>Hash::make('1'),
             'level'=>1,
        ]);
    }
}
