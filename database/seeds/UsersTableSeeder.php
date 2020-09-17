<?php

use App\User;
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
        User::create([
            'name' => "admin",
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
        ]);
        User::create([
            'name' => "ratul",
            'email' => 'ratul794@gmail.com',
            'password' => bcrypt('525100'),
        ]);
    }
}
