<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->create([
            'name' => '倉管示範帳號',
            'email' => 'warehouse@example.com',
            'password' => 'password',
            'api_token' => hash('sha256', 'demo-api-token'),
        ]);

        $items = [
            ['sku' => 'MED-MASK-01', 'name' => '醫用口罩', 'unit' => '盒', 'quantity' => 80, 'safety_stock' => 20, 'location' => 'A-01-01'],
            ['sku' => 'MED-ALC-75', 'name' => '75% 酒精', 'unit' => '瓶', 'quantity' => 8, 'safety_stock' => 15, 'location' => 'A-01-02'],
            ['sku' => 'MED-GLV-M', 'name' => '檢診手套 M', 'unit' => '盒', 'quantity' => 5, 'safety_stock' => 10, 'location' => 'B-02-01'],
            ['sku' => 'MED-THM-01', 'name' => '額溫槍', 'unit' => '支', 'quantity' => 12, 'safety_stock' => 5, 'location' => 'C-01-01'],
            ['sku' => 'MED-GAU-10', 'name' => '紗布塊 10x10', 'unit' => '包', 'quantity' => 40, 'safety_stock' => 12, 'location' => 'B-03-02'],
            ['sku' => 'MED-NS-500', 'name' => '生理食鹽水 500ml', 'unit' => '瓶', 'quantity' => 3, 'safety_stock' => 8, 'location' => 'A-02-03'],
        ];

        foreach ($items as $item) {
            Product::query()->create($item);
        }
    }
}
