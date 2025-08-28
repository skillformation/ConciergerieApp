<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('🌱 Starting database seeding...');
        
        // Désactiver les contraintes de clés étrangères pendant le seeding
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Seeding dans l'ordre correct (dépendances)
        $this->seedInOrder();

        // Réactiver les contraintes de clés étrangères
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('✅ Database seeding completed successfully!');
        $this->displayFinalStatistics();
    }

    /**
     * Execute les seeders dans l'ordre correct
     */
    private function seedInOrder(): void
    {
        $this->command->info('👥 Seeding users with roles...');
        $this->call(UserSeeder::class);

        $this->command->info('📋 Seeding service plans...');
        $this->call(PlanServiceSeeder::class);

        $this->command->info('👤 Seeding clients and their subscriptions...');
        $this->call(ClientAbonnementSeeder::class);
    }

    /**
     * Affiche les statistiques finales du seeding
     */
    private function displayFinalStatistics(): void
    {
        $this->command->info('');
        $this->command->info('📊 Final Statistics:');
        $this->command->line('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');

        // Statistiques des utilisateurs
        $totalUsers = DB::table('users')->count();
        $activeUsers = DB::table('users')->where('is_active', true)->count();
        $this->command->info("👥 Users: {$totalUsers} total ({$activeUsers} active)");

        // Statistiques par rôle
        $usersByRole = DB::table('users')
            ->select('role', DB::raw('count(*) as count'))
            ->groupBy('role')
            ->get();
        
        foreach ($usersByRole as $roleStats) {
            $this->command->info("   - {$roleStats->role}: {$roleStats->count}");
        }

        // Statistiques des plans
        $totalPlans = DB::table('plan_services')->count();
        $activePlans = DB::table('plan_services')->where('actif', true)->count();
        $this->command->info("📋 Service Plans: {$totalPlans} total ({$activePlans} active)");

        // Statistiques par niveau
        $plansByLevel = DB::table('plan_services')
            ->select('niveau_service', DB::raw('count(*) as count'))
            ->where('actif', true)
            ->groupBy('niveau_service')
            ->get();
        
        foreach ($plansByLevel as $levelStats) {
            $this->command->info("   - {$levelStats->niveau_service}: {$levelStats->count}");
        }

        // Statistiques des clients
        $totalClients = DB::table('clients')->count();
        $activeClients = DB::table('clients')->where('actif', true)->count();
        $this->command->info("👤 Clients: {$totalClients} total ({$activeClients} active)");

        // Statistiques par type de client
        $clientsByType = DB::table('clients')
            ->select('type_client', DB::raw('count(*) as count'))
            ->groupBy('type_client')
            ->get();
        
        foreach ($clientsByType as $typeStats) {
            $this->command->info("   - {$typeStats->type_client}: {$typeStats->count}");
        }

        // Statistiques des abonnements
        $totalAbonnements = DB::table('abonnements')->count();
        $activeAbonnements = DB::table('abonnements')->where('statut', 'actif')->count();
        $this->command->info("📝 Abonnements: {$totalAbonnements} total ({$activeAbonnements} active)");

        // Statistiques par statut
        $abonnementsByStatus = DB::table('abonnements')
            ->select('statut', DB::raw('count(*) as count'))
            ->groupBy('statut')
            ->get();
        
        foreach ($abonnementsByStatus as $statusStats) {
            $this->command->info("   - {$statusStats->statut}: {$statusStats->count}");
        }

        // Moyennes utiles
        $avgAbonnementsPerClient = round($totalAbonnements / $totalClients, 2);
        $this->command->info("📈 Average subscriptions per client: {$avgAbonnementsPerClient}");

        // Prix moyens
        $avgPlanPrice = DB::table('plan_services')
            ->where('actif', true)
            ->avg('prix_mensuel');
        $this->command->info("💰 Average plan price: €" . number_format($avgPlanPrice, 2));

        // Revenus potentiels (abonnements actifs)
        $potentialRevenue = DB::table('abonnements')
            ->where('statut', 'actif')
            ->sum('prix_actuel');
        $this->command->info("💵 Potential monthly revenue: €" . number_format($potentialRevenue, 2));

        $this->command->info('━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━');
        $this->command->info('🎉 Ready to test your Filament dashboard!');
        $this->command->info('🔗 Access: /admin');
        $this->command->info('');
    }
}