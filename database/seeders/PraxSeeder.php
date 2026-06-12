<?php

namespace Database\Seeders;

use App\Models\Prax;
use Illuminate\Database\Seeder;

class PraxSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['firma' => 'TechNitra s.r.o.', 'sektor' => 'IT / SaaS', 'stav' => 'Otvorené', 'stavKey' => 'open', 'lokalita' => 'Nitra', 'zadanie' => 'Webová aplikácia pre správu skladu', 'odmena' => '€2 400 / tím', 'popis' => 'Vytvorenie modernej webovej aplikácie na správu skladových zásob s real-time aktualizáciami.', 'kontaktMeno' => 'Marek Tech', 'kontaktEmail' => 'kontakt@technitra.sk', 'kontaktTel' => '+421 37 111 2222'],
            ['firma' => 'Agrobanka a.s.', 'sektor' => 'FinTech', 'stav' => 'Párovanie', 'stavKey' => 'pairing', 'lokalita' => 'Bratislava', 'zadanie' => 'Mobilná aplikácia pre poľnohospodárske úvery', 'odmena' => '€3 000 / tím', 'popis' => 'Mobilná aplikácia umožňujúca farmárom žiadať o mikro-úvery s automatickým scoringom.', 'kontaktMeno' => 'Jana Banková', 'kontaktEmail' => 'kontakt@agrobanka.sk', 'kontaktTel' => '+421 2 333 4444'],
            ['firma' => 'GreenLogistics', 'sektor' => 'Logistika', 'stav' => 'V realizácii', 'stavKey' => 'active', 'lokalita' => 'Nitra', 'zadanie' => 'Route optimization dashboard pre vodičov', 'odmena' => '€2 800 / tím', 'popis' => 'Dashboard pre optimalizáciu trás v reálnom čase.', 'kontaktMeno' => 'Peter Zelený', 'kontaktEmail' => 'info@greenlog.sk', 'kontaktTel' => '+421 37 555 6666'],
            ['firma' => 'MedCenter SK', 'sektor' => 'HealthTech', 'stav' => 'Otvorené', 'stavKey' => 'open', 'lokalita' => 'Nitra', 'zadanie' => 'Systém spracovania lekárskych dát', 'odmena' => '€3 500 / tím', 'popis' => 'Bezpečné spracovanie a vizualizácia lekárskych dát.', 'kontaktMeno' => 'Dr. Lekár', 'kontaktEmail' => 'it@medcenter.sk', 'kontaktTel' => '+421 37 777 8888'],
        ];

        foreach ($data as $row) {
            Prax::create($row);
        }
    }
}