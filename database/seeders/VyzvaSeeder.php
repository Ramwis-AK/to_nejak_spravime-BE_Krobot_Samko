<?php

namespace Database\Seeders;

use App\Models\Vyzva;
use Illuminate\Database\Seeder;

class VyzvaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nazov' => 'Jesenné kolo Programu A', 'program' => 'Program A', 'popis' => 'Registrácia tímov s vlastným nápadom.', 'deadline' => '2025-10-15', 'stav' => 'Otvorená'],
            ['nazov' => 'Q4 zadania Programu B', 'program' => 'Program B', 'popis' => 'Nové firemné zadania pre študentské tímy.', 'deadline' => '2025-11-30', 'stav' => 'Otvorená'],
            ['nazov' => 'Workshop: Executive Summary', 'program' => 'Program A', 'popis' => 'Bezplatný workshop pre uchádzačov.', 'deadline' => '2025-09-25', 'stav' => 'Otvorená'],
        ];

        foreach ($data as $row) {
            Vyzva::create($row);
        }
    }
}