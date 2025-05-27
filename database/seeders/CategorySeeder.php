<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => "Смартфоны",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "Зарядки",
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => "Чехлы",
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Category::insert($data);
    }
}
