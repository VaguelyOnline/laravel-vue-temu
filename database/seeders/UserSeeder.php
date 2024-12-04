<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        User::factory(10)->create();

        User::create([
            'name' => 'User',
            'email' => 'user@temu.com',
            'password' => 'password'
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@temu.com',
            'password' => 'password'
        ]);

        $admin->assignRole('admin');
    }
}
