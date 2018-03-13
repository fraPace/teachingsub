<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run()
    {

        $admin_password = str_random(16);
        $user = User::create([
            'username' => 'admin',
            'name' => 'admin',
            'password' => Hash::make($admin_password),
        ]);

        $user->assignRole('admin');

        $this->command->warn('Created Admin user with the following password: '.$admin_password.' Make sure to save it or change it!');
    }
}