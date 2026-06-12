<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            NovinkaSeeder::class,
            StartupSeeder::class,
            PraxSeeder::class,
            PartnerSeeder::class,
            MentorSeeder::class,
            VyzvaSeeder::class,
        ]);
    }
}