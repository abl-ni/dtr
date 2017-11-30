<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'type' => 'Admin',
            'password' => bcrypt('password'),
        ]);

        DB::table('users')->insert([
            'name' => 'developer',
            'email' => 'dev@gmail.com',
            'type' => 'Dev',
            'password' => bcrypt('password'),
        ]);

        DB::table('users')->insert([
            'name' => 'project manager',
            'email' => 'pm@gmail.com',
            'type' => 'PM',
            'password' => bcrypt('password'),
        ]);
    }
}
