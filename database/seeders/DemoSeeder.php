<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Startup;
use App\Models\Prax;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        // === PROGRAM A — firmy + ich startupy ===
        // [názov, email, oblasť, fáza, lokalita, value proposition, investícia]
        $programA = [
            ['EcoFlow', 'ecoflow@nti.sk', 'Energy', 'Seed', 'DE', 'Domáce batérie z recyklovaných plastov', '$200k ARR'],
            ['HealthAI', 'healthai@nti.sk', 'Health', 'Series A', 'USA', 'Diagnostika rakoviny pomocou mobilu', '50k pacientov'],
            ['AgroSense', 'agrosense@nti.sk', 'AgriTech', 'Pre-seed', 'SK', 'IoT senzory pre inteligentné farmy', '€80k grant'],
            ['EduFlow', 'eduflow@nti.sk', 'EdTech', 'Seed', 'CZ', 'Personalizované učenie pomocou AI', '$150k ARR'],
        ];
        foreach ($programA as $i => $a) {
            $u = User::create([
                'meno' => $a[0], 'priezvisko' => '', 'email' => $a[1],
                'password' => 'heslo123', 'rola' => 'firma', 'sektor' => $a[2], 'email_verified_at' => now(),
            ]);
            Startup::create([
                'user_id' => $u->id, 'kod' => 'STA-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'nazov' => $a[0], 'oblast' => $a[2], 'faza' => $a[3], 'lokalita' => $a[4],
                'vp' => $a[5], 'investicia' => $a[6],
                'zakladatel' => $a[0], 'kontaktEmail' => $a[1],
            ]);
        }

        // === PROGRAM B — firmy + ich zadania ===
        // [názov, email, sektor, lokalita, zadanie, odmena, popis]
        $programB = [
            ['TechNitra s.r.o.', 'technitra@nti.sk', 'IT / SaaS', 'Nitra', 'Webová aplikácia pre správu skladu', '€2 400 / tím', 'Real-time správa skladových zásob.'],
            ['Agrobanka a.s.', 'agrobanka@nti.sk', 'FinTech', 'Bratislava', 'Mobilná aplikácia pre poľnohospodárske úvery', '€3 000 / tím', 'Mikro-úvery pre farmárov s automatickým scoringom.'],
            ['GreenLogistics', 'greenlogistics@nti.sk', 'Logistika', 'Nitra', 'Route optimization dashboard', '€2 800 / tím', 'Plánovanie a optimalizácia trás pre vodičov.'],
            ['MedCenter SK', 'medcenter@nti.sk', 'HealthTech', 'Nitra', 'Systém spracovania lekárskych dát', '€3 500 / tím', 'Bezpečné spracovanie a vizualizácia lekárskych dát.'],
        ];
        foreach ($programB as $i => $b) {
            $u = User::create([
                'meno' => $b[0], 'priezvisko' => '', 'email' => $b[1],
                'password' => 'heslo123', 'rola' => 'firma', 'sektor' => $b[2], 'email_verified_at' => now(),
            ]);
            Prax::create([
                'user_id' => $u->id, 'kod' => 'ZAD-' . str_pad($i + 1, 4, '0', STR_PAD_LEFT),
                'firma' => $b[0], 'zadanie' => $b[4], 'sektor' => $b[2], 'lokalita' => $b[3],
                'odmena' => $b[5], 'popis' => $b[6], 'stav' => 'Otvorené', 'stavKey' => 'open',
                'kontaktMeno' => $b[0], 'kontaktEmail' => $b[1],
            ]);
        }
    }
}