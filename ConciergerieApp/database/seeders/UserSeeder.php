<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Vider la table des utilisateurs existants
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Administrateur
        User::create([
            'name' => 'Administrateur Principal',
            'email' => 'admin@conciergerie.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Manager
        User::create([
            'name' => 'Marie Dubois',
            'email' => 'manager@conciergerie.com',
            'password' => Hash::make('password123'),
            'role' => 'manager',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Employé
        User::create([
            'name' => 'Jean Martin',
            'email' => 'employee@conciergerie.com',
            'password' => Hash::make('password123'),
            'role' => 'employee',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Client
        User::create([
            'name' => 'Sophie Lambert',
            'email' => 'client@conciergerie.com',
            'password' => Hash::make('password123'),
            'role' => 'client',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        // Client inactif pour tester la fonctionnalité
        User::create([
            'name' => 'Client Inactif',
            'email' => 'inactif@conciergerie.com',
            'password' => Hash::make('password123'),
            'role' => 'client',
            'is_active' => false,
            'email_verified_at' => now(),
        ]);
    }
}