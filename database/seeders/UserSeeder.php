<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // [rola, meno, priezvisko, email] — heslo: heslo123
        $ucty = [
            ['student', 'Študent', 'Testovací', 'student@nti.sk'],
            ['firma', 'TestFirma s.r.o.', '', 'firma@nti.sk'],
            ['mentor', 'Mentor', 'Testovací', 'mentor@nti.sk'],
        ];

        foreach ($ucty as $u) {
            User::create([
                'meno' => $u[1],
                'priezvisko' => $u[2],
                'email' => $u[3],              // e-mail z poľa (nie z roly)
                'password' => 'heslo123',
                'rola' => $u[0],               // rola ostáva 'vedouci'
                'email_verified_at' => now(),
            ]);
        }
    }
}
  