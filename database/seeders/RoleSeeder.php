<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::insert([
            ['name' => 'admin', 'label' => 'Administrator'],
            ['name' => 'priest', 'label' => 'Priest'],
            ['name' => 'scc_leader', 'label' => 'SCC Leader'],
        ]);
    }
}
