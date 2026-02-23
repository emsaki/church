<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@pmis.com',
            ],
            [
                'name'              => 'System Administrator',
                'password'          => Hash::make('ChangeMe123!'),
                'role'              => 'admin',
                'email_verified_at' => now(),
            ]
        );
    }
}
