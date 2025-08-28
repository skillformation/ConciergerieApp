<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\PlanService;
use App\Models\Abonnement;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientAbonnementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Vider les tables dans le bon ordre
        Abonnement::truncate();
        Client::truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Creating clients and their subscriptions...');

        // S'assurer qu'il y a des plans disponibles
        $plansActifs = PlanService::where('actif', true)->get();
        
        if ($plansActifs->isEmpty()) {
            $this->command->warn('No active plans found. Running PlanServiceSeeder first...');
            $this->call(PlanServiceSeeder::class);
            $plansActifs = PlanService::where('actif', true)->get();
        }

        // Créer 50 clients avec leurs abonnements
        $this->createClientsWithSubscriptions($plansActifs);

        // Statistiques finales
        $clientsCount = Client::count();
        $abonnementsCount = Abonnement::count();
        $avgAbonnementsPerClient = round($abonnementsCount / $clientsCount, 2);

        $this->command->info("ClientAbonnementSeeder completed:");
        $this->command->info("- {$clientsCount} clients created");
        $this->command->info("- {$abonnementsCount} abonnements created");
        $this->command->info("- {$avgAbonnementsPerClient} abonnements per client on average");
    }

    /**
     * Créer des clients avec leurs abonnements
     */
    private function createClientsWithSubscriptions($plansActifs): void
    {
        // Créer des clients particuliers (70% du total)
        $this->createClientsOfType('particulier', 35, $plansActifs);
        
        // Créer des clients entreprise (30% du total)
        $this->createClientsOfType('entreprise', 15, $plansActifs);
        
        $this->command->info('Base clients and subscriptions created');
    }

    /**
     * Créer des clients d'un type spécifique avec leurs abonnements
     */
    private function createClientsOfType(string $type, int $count, $plansActifs): void
    {
        for ($i = 0; $i < $count; $i++) {
            // Créer le client
            $client = Client::factory()
                ->when($type === 'particulier', fn($factory) => $factory->particulier())
                ->when($type === 'entreprise', fn($factory) => $factory->entreprise())
                ->create();

            // Déterminer le nombre d'abonnements (1 à 3 par client)
            $nombreAbonnements = $this->determineNombreAbonnements();

            // Filtrer les plans appropriés selon le type de client
            $plansFiltres = $this->filterPlansForClientType($plansActifs, $type);

            // Créer les abonnements pour ce client
            $this->createAbonnementsForClient($client, $plansFiltres, $nombreAbonnements);

            if (($i + 1) % 10 == 0) {
                $this->command->info("Created " . ($i + 1) . " {$type} clients with their subscriptions");
            }
        }
    }

    /**
     * Détermine le nombre d'abonnements pour un client (probabilités réalistes)
     */
    private function determineNombreAbonnements(): int
    {
        $rand = rand(1, 100);
        
        if ($rand <= 60) {
            return 1; // 60% ont 1 abonnement
        } elseif ($rand <= 85) {
            return 2; // 25% ont 2 abonnements
        } else {
            return 3; // 15% ont 3 abonnements
        }
    }

    /**
     * Filtre les plans selon le type de client
     */
    private function filterPlansForClientType($plansActifs, string $clientType)
    {
        if ($clientType === 'particulier') {
            // Les particuliers préfèrent les plans particulier et mixte
            return $plansActifs->whereIn('target', ['particulier', 'mixte']);
        } else {
            // Les entreprises peuvent prendre tous types de plans
            return $plansActifs;
        }
    }

    /**
     * Crée les abonnements pour un client donné
     */
    private function createAbonnementsForClient(Client $client, $plansFiltres, int $nombreAbonnements): void
    {
        // S'assurer qu'on a assez de plans
        if ($plansFiltres->count() < $nombreAbonnements) {
            $nombreAbonnements = $plansFiltres->count();
        }

        // Sélectionner des plans uniques pour ce client
        $plansSelectionnes = $plansFiltres->random(min($nombreAbonnements, $plansFiltres->count()));

        foreach ($plansSelectionnes as $index => $plan) {
            // Créer différents types d'abonnements avec des probabilités réalistes
            $this->createSpecificAbonnement($client, $plan, $index);
        }
    }

    /**
     * Crée un abonnement spécifique selon des scénarios réalistes
     */
    private function createSpecificAbonnement(Client $client, PlanService $plan, int $index): void
    {
        $rand = rand(1, 100);

        if ($index === 0) {
            // Le premier abonnement est généralement actif et récent
            if ($rand <= 70) {
                Abonnement::factory()
                    ->forClient($client)
                    ->forPlan($plan)
                    ->actif()
                    ->recent()
                    ->create();
            } else {
                Abonnement::factory()
                    ->forClient($client)
                    ->forPlan($plan)
                    ->actif()
                    ->create();
            }
        } elseif ($index === 1) {
            // Le deuxième abonnement peut être de différents types
            if ($rand <= 40) {
                // Abonnement actif standard
                Abonnement::factory()
                    ->forClient($client)
                    ->forPlan($plan)
                    ->actif()
                    ->create();
            } elseif ($rand <= 65) {
                // Abonnement long terme
                Abonnement::factory()
                    ->forClient($client)
                    ->forPlan($plan)
                    ->longTerme()
                    ->create();
            } elseif ($rand <= 85) {
                // Abonnement expiré
                Abonnement::factory()
                    ->forClient($client)
                    ->forPlan($plan)
                    ->expire()
                    ->create();
            } else {
                // Abonnement suspendu
                Abonnement::factory()
                    ->forClient($client)
                    ->forPlan($plan)
                    ->suspendu()
                    ->create();
            }
        } else {
            // Le troisième abonnement (plus rare) - souvent ancien ou annulé
            if ($rand <= 30) {
                Abonnement::factory()
                    ->forClient($client)
                    ->forPlan($plan)
                    ->actif()
                    ->create();
            } elseif ($rand <= 50) {
                Abonnement::factory()
                    ->forClient($client)
                    ->forPlan($plan)
                    ->expire()
                    ->create();
            } elseif ($rand <= 70) {
                Abonnement::factory()
                    ->forClient($client)
                    ->forPlan($plan)
                    ->annule()
                    ->create();
            } else {
                Abonnement::factory()
                    ->forClient($client)
                    ->forPlan($plan)
                    ->longTerme()
                    ->create();
            }
        }
    }
}