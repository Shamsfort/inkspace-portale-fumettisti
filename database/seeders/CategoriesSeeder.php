<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Azione', 'Avventura', 'Commedia', 'Fantasy', 'Horror', 'Mistero', 'Romance', 'Sci-fi', 'Supereroi'] as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}
