<?php

namespace Database\Seeders;

use App\Models\CategorySpend;
use Illuminate\Database\Seeder;

class CategorySpendSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Alimentação',
            'Transporte',
            'Saúde',
            'Educação',
            'Lazer',
            'Moradia',
            'Serviços',
            'Outros',
        ];

        foreach ($categories as $category) {
            CategorySpend::firstOrCreate(['name' => $category]);
        }
    }
}
