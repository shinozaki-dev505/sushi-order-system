<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Table;

class TableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tables = [
            ['table_number' => '1', 'seats' => 4, 'status' => 'available'],
            ['table_number' => '2', 'seats' => 4, 'status' => 'available'],
            ['table_number' => '3', 'seats' => 6, 'status' => 'available'],
            ['table_number' => '4', 'seats' => 6, 'status' => 'available'],
            ['table_number' => 'カウンター1', 'seats' => 1, 'status' => 'available'],
            ['table_number' => 'カウンター2', 'seats' => 1, 'status' => 'available'],
        ];

        foreach ($tables as $table) {
            Table::create($table);
        }
    }
}
