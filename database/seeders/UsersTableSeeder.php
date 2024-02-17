<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Contoh menggunakan Query Builder
        User::create([
            'name' => 'samsul',
            'email' => 'smsulgans16@gmail.com',
            'password' => bcrypt('samsul123'),
        ]);

        // Atau contoh menggunakan model Eloquent
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
        ]);
    }
}
