<?php

namespace Database\Seeders;

use App\Models\Mentor;
use Illuminate\Database\Seeder;

class MentorSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['meno' => 'Dominik Halvoník', 'oblast' => 'Architektúra & Backend', 'skusenosti' => '12+ rokov, solution architect'],
            ['meno' => 'Jana Kováčová', 'oblast' => 'UX / Produktový dizajn', 'skusenosti' => '8 rokov, ex-Slido'],
            ['meno' => 'Martin Blaho', 'oblast' => 'Biznis & Financie', 'skusenosti' => 'Investor, 3 exits'],
            ['meno' => 'Peter Šimko', 'oblast' => 'AI & Dáta', 'skusenosti' => 'PhD, ML engineer'],
        ];

        foreach ($data as $row) {
            Mentor::create($row);
        }
    }
}