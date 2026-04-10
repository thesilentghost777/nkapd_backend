<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BrFinal\User;
use App\Models\BrFinal\Referral;
use Illuminate\Support\Facades\Hash;

class BrFinalSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        $admin = User::create([
            'nom' => 'Admin', 'prenom' => 'System', 'telephone' => '690000000',
            'email' => 'admin@brfinal.com', 'password' => Hash::make('password'),
            'role' => 'admin', 'statut' => 'membre', 'adhesion_payee' => true,
        ]);

        // Membres test
        $membre1 = User::create([
            'nom' => 'Kamga', 'prenom' => 'Jean', 'telephone' => '691111111',
            'email' => 'jean@test.com', 'password' => Hash::make('password'),
            'statut' => 'membre', 'adhesion_payee' => true, 'whatsapp' => '691111111',
            'ville' => 'Douala', 'quartier' => 'Akwa',
        ]);

        $membre2 = User::create([
            'nom' => 'Fotso', 'prenom' => 'Marie', 'telephone' => '692222222',
            'email' => 'marie@test.com', 'password' => Hash::make('password'),
            'statut' => 'membre', 'adhesion_payee' => true, 'whatsapp' => '692222222',
        ]);

        $membre3 = User::create([
            'nom' => 'Nguemo', 'prenom' => 'Paul', 'telephone' => '693333333',
            'password' => Hash::make('password'), 'statut' => 'en_attente',
        ]);

        // Parrainage
        Referral::create(['parrain_id' => $membre1->id, 'filleul_id' => $membre2->id, 'statut' => 'actif']);
        Referral::create(['parrain_id' => $membre1->id, 'filleul_id' => $membre3->id, 'statut' => 'en_attente']);
    }
}
