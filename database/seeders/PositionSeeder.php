<?php

namespace Database\Seeders;

use App\Models\Position;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $positions = [
            ['name' => 'Chairman', 'slug' => 'chairman', 'order' => 1],
            ['name' => 'Vice Chairman', 'slug' => 'vice_chairman', 'order' => 2],
            ['name' => 'Secretary', 'slug' => 'secretary', 'order' => 3],
            ['name' => 'Accountant / Bursar', 'slug' => 'accountant', 'order' => 4],
        ];

        foreach ($positions as $pos) {
            Position::firstOrCreate(['slug' => $pos['slug']], $pos);
        }
    }
}
