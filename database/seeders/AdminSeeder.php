<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@example.com',
            'birth_date' => '1990-01-01',
            'gender' => 'male',
            'password' => Hash::make('password'),
        ]);

        Admin::create([
            'first_name' => 'John',
            'last_name' => 'Manager',
            'email' => 'john@example.com',
            'birth_date' => '1985-05-15',
            'gender' => 'male',
            'password' => Hash::make('password'),
        ]);

        Admin::create([
            'first_name' => 'Sarah',
            'last_name' => 'Wilson',
            'email' => 'sarah@example.com',
            'birth_date' => '1992-08-20',
            'gender' => 'female',
            'password' => Hash::make('password'),
        ]);
    }
}