<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'mail' => 'test@example.com',
        // ]);\

        //admin account
        User::create([
            'name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '09792697601',
            'address' => 'Mdy',
            'role' => 'admin',
            'password' => Hash::make('p@ssword'),
            'gender' => 'male'
        ]);


        User::create([
            'name' => 'Tiffany',
            'email' => 'tiffany@gmail.com',
            'phone' => '09778342984',
            'address' => 'Muse',
            'role' => 'shop_admin',
            'password' => Hash::make('tiffany123'),
            'gender' => 'female'
        ]);
    }
}
