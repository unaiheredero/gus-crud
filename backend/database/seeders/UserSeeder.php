<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'passHash' => bcrypt('admin123'),
            'isAdmin' => true,
            'isBanned' => false,
        ]);

        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@example.com',
            'passHash' => bcrypt('user123'),
            'isAdmin' => false,
            'isBanned' => false,
        ]);
    }
}
