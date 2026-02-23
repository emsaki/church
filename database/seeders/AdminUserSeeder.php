<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function () {

            /* -------------------------------
             | 1. Ensure ADMIN role exists
             * ------------------------------- */
            $adminRole = Role::updateOrCreate(
                ['name' => 'admin'],
                ['label' => 'System Administrator']
            );

            /* -------------------------------
             | 2. Create / Update Admin user
             * ------------------------------- */
            $adminUser = User::updateOrCreate(
                ['email' => 'admin@pmis.org'],
                [
                    'name'              => 'System Administrator',
                    'password'          => Hash::make(env('ADMIN_PASSWORD', 'ChangeMe123!')),
                    'email_verified_at' => now(),
                ]
            );

            /* -------------------------------
             | 3. Attach role (pivot-safe)
             * ------------------------------- */
            if (! $adminUser->roles()->where('roles.id', $adminRole->id)->exists()) {
                $adminUser->roles()->attach($adminRole->id);
            }
        });
    }
}
