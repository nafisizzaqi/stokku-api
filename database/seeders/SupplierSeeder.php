<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = [
            [
                'name' => 'Test1',
                'email' => 'test1@gmail.com',
                'phone' => '0099988877765',
                'address' => 'Jakarta'
            ],
            [
                'name' => 'Test2',
                'email' => 'test2@gmail.com',
                'phone' => '123456789656',
                'address' => 'Bandung'
            ],
            [
                'name' => 'Test2',
                'email' => 'test2@gmail.com',
                'phone' => '723672854672',
                'address' => 'Yogyakarta'
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::create($supplier);
        }
    }
}
