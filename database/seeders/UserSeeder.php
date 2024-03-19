<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name' => 'Admin',
                'email' => 'Admin@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Prueba123')
            ]
        );

        User::create(
            [
                'name' => 'angel',
                'email' => 'angel@admin.com',
                'email_verified_at' => now(),
                'password' => Hash::make('Prueba123')
            ]
        );

        // User::insert([
        //     [
        //         'name' => 'Admin',
        //         'email' => 'Admin@admin.com',
        //         'email_verified_at' => now(),
        //         'password' => Hash::make('Prueba123')
        //     ],
        //     [
        //         'name' => 'Admin',
        //         'email' => 'Admin@admin.com',
        //         'email_verified_at' => now(),
        //         'password' => Hash::make('Prueba123')
        //     ]
        // ]);

        // User::factory()
        // ->count(10)
        // ->has(
        //     Image::factory()
        // )
        // ->create();
    }
}
