<?php

namespace Database\Seeders;

use App\Features\Product\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->create([
                         'name'     => 'Admin User',
                         'email'    => 'admin@gmail.com',
                         "is_admin" => true,
                     ]);


        User::factory()
            ->create([
                         'name'  => 'Member User',
                         'email' => 'member@gmail.com',
                     ]);


        User::factory()
            ->create([
                         'name'  => 'Member User1',
                         'email' => 'member-1@gmail.com',
                     ]);
    }
}
