<?php

use Illuminate\Database\Seeder;

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
            [
                'name' => 'Sultan Imam Muttaqin',
                'email' => 'test@gmail.com',
                'password' => bcrypt('password'),
                'photo' => 'user.png',
                'level' => 1
            ],
            [
                'name' => 'kilamieaz',
                'email' => 'test2@gmail.com',
                'password' => bcrypt('password'),
                'photo' => 'user.png',
                'level' => 2
            ]
        ]);
    }
}
