<?php

namespace Database\Seeders;

use App\Models\Novinka;
use Illuminate\Database\Seeder;

class NovinkaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'titul' => 'NTI otvára jesenné kolo Programu A',
                'datum' => '2025-09-10',
                'perex' => 'Registrácia pre tímy s vlastným inovatívnym nápadom je otvorená do 15. októbra 2025.',
                'kategoria' => 'Oznámenie',
                'obsah' => 'Plné znenie oznámenia o jesennom kole Programu A...',
            ],
            [
                'titul' => 'Workshopy k tvorbe Executive Summary',
                'datum' => '2025-09-10',
                'perex' => 'Séria bezplatných workshopov pre tímy prihlasujúce sa do Programu A.',
                'kategoria' => 'Udalosť',
                'obsah' => 'Detaily o workshopoch...',
            ],
            [
                'titul' => 'EcoFlow získal €200k ARR — úspešný exit z inkubátora',
                'datum' => '2025-08-15',
                'perex' => 'Startup EcoFlow, ktorý prešiel Programom A, oznámil prvý veľký míľnik.',
                'kategoria' => 'Úspešný príbeh',
                'obsah' => 'Príbeh startupu EcoFlow...',
            ],
            [
                'titul' => 'Nové firemné zadania v Programme B pre Q4',
                'datum' => '2025-07-20',
                'perex' => 'TechNitra, MedCenter SK a ďalšie spoločnosti zverejnili nové zadania.',
                'kategoria' => 'Program B',
                'obsah' => 'Prehľad nových zadaní...',
            ],
        ];

        foreach ($data as $row) {
            Novinka::create($row);
        }
    }
}