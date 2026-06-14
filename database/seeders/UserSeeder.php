<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // ukážkové účty (heslo: heslo123). vedouci = študent, ktorý si vytvorí tím
        $ucty = [
            ['student', 'Študent', 'Testovací', 'student@nti.sk'],
            ['student', 'Vedúci', 'Tímu', 'vedouci@nti.sk'],
            ['firma', 'TestFirma s.r.o.', '', 'firma@nti.sk'],
            ['mentor', 'Mentor', 'Testovací', 'mentor@nti.sk'],
            ['admin', 'NTI', 'Admin', 'admin@nti.sk'],
            ['komisia', 'Komisia', 'NTI', 'komisia@nti.sk'],
        ];

        foreach ($ucty as $u) {
            User::create([
                'meno' => $u[1], 'priezvisko' => $u[2], 'email' => $u[3],
                'password' => 'heslo123', 'rola' => $u[0], 'email_verified_at' => now(),
            ]);
        }
    }
}