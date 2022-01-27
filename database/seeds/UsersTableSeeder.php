<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'admin',
                'email' => 'admin@grtech.com.my',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'is_admin' => 1,
                'remember_token' => Str::random(10)
            ],
            [
                'name' => 'user',
                'email' => 'user@grtech.com.my',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
                'is_admin' => 0,
                'remember_token' => Str::random(10)
            ]
        ];

        DB::table('users')->insert($data);
    }
}
