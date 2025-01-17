<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin User',
            'email' => '',
            'password' => bcrypt(''),
            'is_admin' => true,
            'is_banned' => false,
        ]);

        DB::table('users')->insert([
            'name' => 'Regular User',
            'email' => '',
            'password' => bcrypt(''),
            'is_admin' => false,
            'is_banned' => false,
        ]);
    }
}
