<?php

namespace Database\Seeders;

use App\Models\Riviste;
use Illuminate\Database\Seeder;

class RivisteSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['nome' => 'Shonen Jump', 'nazione' => 'JP'],
            ['nome' => 'Linus', 'nazione' => 'IT'],
            ['nome' => 'Heavy Metal', 'nazione' => 'US'],
            ['nome' => 'Métal Hurlant', 'nazione' => 'FR'],
        ] as $rivista) {
            Riviste::firstOrCreate($rivista);
        }
    }
}
