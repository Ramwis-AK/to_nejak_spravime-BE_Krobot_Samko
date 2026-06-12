<?php

namespace Database\Seeders;

use App\Models\Partner;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nazov' => 'UKF Nitra', 'typ' => 'Akademický', 'popis' => 'Univerzita Konštantína Filozofa v Nitre — zakladajúci akademický partner programu.'],
            ['nazov' => 'TechNitra s.r.o.', 'typ' => 'Firemný', 'popis' => 'Regionálny IT líder, zadávateľ výziev v Programme B a mentor tímov.'],
            ['nazov' => 'Agrobanka a.s.', 'typ' => 'Firemný', 'popis' => 'Finančný partner a zadávateľ FinTech zadaní.'],
            ['nazov' => 'Slovak Innovation Hub', 'typ' => 'Ekosystém', 'popis' => 'Napojenie na národný inovačný ekosystém a cezhraničné príležitosti.'],
            ['nazov' => 'GreenLogistics', 'typ' => 'Firemný', 'popis' => 'Partner v oblasti logistiky a udržateľných technológií.'],
            ['nazov' => 'MedCenter SK', 'typ' => 'Firemný', 'popis' => 'Zdravotnícka organizácia a partner HealthTech projektov.'],
        ];

        foreach ($data as $row) {
            Partner::create($row);
        }
    }
}