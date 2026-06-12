<?php

namespace Database\Seeders;

use App\Models\Startup;
use Illuminate\Database\Seeder;

class StartupSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nazov' => 'EcoFlow', 'oblast' => 'Energy', 'faza' => 'Seed', 'lokalita' => 'DE', 'vp' => 'Domáce batérie z recyklovaných plastov', 'investicia' => '$200k ARR', 'zakladatel' => 'Petra Hlavná', 'kontaktEmail' => 'petra@ecoflow.io', 'kontaktTel' => '+421 900 111 222'],
            ['nazov' => 'HealthAI', 'oblast' => 'Health', 'faza' => 'Series A', 'lokalita' => 'USA', 'vp' => 'Diagnostika rakoviny pomocou mobilu', 'investicia' => '50k pacientov', 'zakladatel' => 'John Doe', 'kontaktEmail' => 'john@healthai.com', 'kontaktTel' => '+1 555 0100'],
            ['nazov' => 'AgroSense', 'oblast' => 'AgriTech', 'faza' => 'Pre-seed', 'lokalita' => 'SK', 'vp' => 'IoT senzory pre inteligentné farmy', 'investicia' => '€80k grant', 'zakladatel' => 'Ján Novák', 'kontaktEmail' => 'jan@agrosense.sk', 'kontaktTel' => '+421 900 333 444'],
            ['nazov' => 'EduFlow', 'oblast' => 'EdTech', 'faza' => 'Seed', 'lokalita' => 'CZ', 'vp' => 'Personalizované učenie pomocou AI', 'investicia' => '$150k ARR', 'zakladatel' => 'Eva Malá', 'kontaktEmail' => 'eva@eduflow.cz', 'kontaktTel' => '+420 777 000 111'],
        ];

        foreach ($data as $row) {
            Startup::create($row);
        }
    }
}