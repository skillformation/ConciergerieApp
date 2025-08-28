<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Client;

class ClientSeeder extends Seeder
{
    public function run()
    {
        Client::create([
            'nom' => 'Dupont',
            'prenom' => 'Jean',
            'email' => 'jean.dupont@email.com',
            'type_client' => 'particulier',
            'actif' => true,
        ]);

        Client::create([
            'nom' => 'Martin',
            'prenom' => 'Marie',
            'email' => 'marie.martin@email.com',
            'type_client' => 'entreprise',
            'actif' => true,
        ]);

        Client::create([
            'nom' => 'Durand',
            'prenom' => 'Pierre',
            'email' => 'pierre.durand@email.com',
            'type_client' => 'particulier',
            'actif' => false,
        ]);
    }
}