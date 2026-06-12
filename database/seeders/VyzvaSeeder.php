<?php

namespace Database\Seeders;

use App\Models\Vyzva;
use Illuminate\Database\Seeder;

class VyzvaSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nazov' => 'Jesenné kolo Programu A',
                'program' => 'Program A',
                'popis' => 'Grantový inkubačný program pre tímy s vlastným inovatívnym nápadom. Výsledkom je startup alebo produkt s financovaním a mentoringom.',
                'otvorenie' => '2025-09-01',
                'deadline' => '2025-10-15',
                'stav' => 'Otvorená',
                'kategorie' => ['Vývoj softvéru', 'AI a dátové technológie', 'Webové aplikácie', 'Herný vývoj', 'IoT a embedded systémy'],
                'kriteria' => ['Minimálna veľkosť tímu: 3 členovia', 'Bez prenášaných predmetov', 'Priemer profilových predmetov nad stanovenou hranicou', 'Akademická spôsobilosť cez čestné vyhlásenie'],
                'dokumenty' => ['Executive Summary', 'Technická architektúra', 'Roadmapa', 'Rozpočet', 'Riziková analýza', 'Monetizačný model'],
                'faq' => [
                    ['otazka' => 'Koľko členov musí mať tím?', 'odpoved' => 'Minimálne 3 členovia.'],
                    ['otazka' => 'Ako sa overuje akademická spôsobilosť?', 'odpoved' => 'V MVP cez čestné vyhlásenie a upload podkladov.'],
                ],
            ],
            [
                'nazov' => 'Q4 zadania Programu B',
                'program' => 'Program B',
                'popis' => 'Živá prax — reálne zadania od firiem pre študentské tímy. Odmena, Product Owner a mentor NTI.',
                'otvorenie' => '2025-10-01',
                'deadline' => '2025-11-30',
                'stav' => 'Otvorená',
                'kategorie' => ['IT / SaaS', 'FinTech', 'HealthTech', 'Logistika'],
                'kriteria' => ['Študentský tím', 'Životopisy členov', 'Motivačný list', 'Návrh riešenia'],
                'dokumenty' => ['Životopisy tímu', 'Motivačný list', 'Návrh riešenia'],
                'faq' => [
                    ['otazka' => 'Kto vyberá tím?', 'odpoved' => 'Komisia NTI spolu so zástupcom firmy.'],
                    ['otazka' => 'Je prax platená?', 'odpoved' => 'Áno, odmena je definovaná pri každom zadaní.'],
                ],
            ],
            [
                'nazov' => 'Workshop: Executive Summary',
                'program' => 'Program A',
                'popis' => 'Bezplatný workshop pre uchádzačov o Program A — ako napísať silné Executive Summary.',
                'otvorenie' => '2025-09-10',
                'deadline' => '2025-09-25',
                'stav' => 'Otvorená',
                'kategorie' => [],
                'kriteria' => [],
                'dokumenty' => [],
                'faq' => [],
            ],
        ];

        foreach ($data as $row) {
            Vyzva::create($row);
        }
    }
}