<?php

namespace Database\Seeders;

use App\Models\PlanService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlanServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Vider la table
        PlanService::truncate();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Créer des plans spécifiques et réalistes
        $this->createSpecificPlans();

        // Créer des plans générés aléatoirement
        $this->createRandomPlans();

        $this->command->info('PlanServiceSeeder completed: ' . PlanService::count() . ' plans created.');
    }

    /**
     * Créer des plans spécifiques et réalistes
     */
    private function createSpecificPlans(): void
    {
        // Plans pour particuliers
        PlanService::create([
            'nom_plan' => 'Starter',
            'prix_mensuel' => 9.99,
            'description' => 'Plan d\'entrée parfait pour débuter avec les fonctionnalités essentielles',
            'niveau_service' => 'basique',
            'target' => 'particulier',
            'positionnement' => 'Solution économique et accessible pour commencer',
            'actif' => true,
        ]);

        PlanService::create([
            'nom_plan' => 'Standard',
            'prix_mensuel' => 29.99,
            'description' => 'Plan équilibré avec toutes les fonctionnalités principales pour un usage quotidien',
            'niveau_service' => 'standard',
            'target' => 'particulier',
            'positionnement' => 'Le choix le plus populaire - équilibre parfait',
            'actif' => true,
        ]);

        PlanService::create([
            'nom_plan' => 'Premium Particulier',
            'prix_mensuel' => 59.99,
            'description' => 'Plan haut de gamme avec fonctionnalités avancées et support prioritaire',
            'niveau_service' => 'premium',
            'target' => 'particulier',
            'positionnement' => 'Pour les utilisateurs exigeants qui veulent le maximum',
            'actif' => true,
        ]);

        // Plans pour entreprises
        PlanService::create([
            'nom_plan' => 'Business',
            'prix_mensuel' => 79.99,
            'description' => 'Solution professionnelle complète pour les équipes et petites entreprises',
            'niveau_service' => 'standard',
            'target' => 'entreprise',
            'positionnement' => 'Idéal pour les équipes collaboratives',
            'actif' => true,
        ]);

        PlanService::create([
            'nom_plan' => 'Professional',
            'prix_mensuel' => 149.99,
            'description' => 'Plan avancé avec outils de gestion d\'équipe et fonctionnalités métier',
            'niveau_service' => 'premium',
            'target' => 'entreprise',
            'positionnement' => 'Solution complète pour entreprises en croissance',
            'actif' => true,
        ]);

        PlanService::create([
            'nom_plan' => 'Enterprise',
            'prix_mensuel' => 499.99,
            'description' => 'Solution sur mesure avec support dédié et fonctionnalités personnalisées',
            'niveau_service' => 'entreprise',
            'target' => 'entreprise',
            'positionnement' => 'Pour les grandes organisations avec besoins spécifiques',
            'actif' => true,
        ]);

        // Plans mixtes
        PlanService::create([
            'nom_plan' => 'Polyvalent',
            'prix_mensuel' => 39.99,
            'description' => 'Plan spécialement conçu pour tous types d\'utilisateurs',
            'niveau_service' => 'standard',
            'target' => 'mixte',
            'positionnement' => 'Solution flexible pour tous',
            'actif' => true,
        ]);

        // Plan inactif (pour tester les filtres)
        PlanService::create([
            'nom_plan' => 'Legacy',
            'prix_mensuel' => 19.99,
            'description' => 'Ancien plan désormais indisponible pour les nouveaux clients',
            'niveau_service' => 'basique',
            'target' => 'particulier',
            'positionnement' => 'Plan historique en fin de vie',
            'actif' => false,
        ]);

        // Plan très haut de gamme
        PlanService::create([
            'nom_plan' => 'Platinum Enterprise',
            'prix_mensuel' => 999.99,
            'description' => 'Plan illimité avec toutes les fonctionnalités et support 24/7',
            'niveau_service' => 'entreprise',
            'target' => 'entreprise',
            'positionnement' => 'Excellence absolue - sans compromis',
            'actif' => true,
        ]);
    }

    /**
     * Créer des plans générés aléatoirement
     */
    private function createRandomPlans(): void
    {
        // Plans pour particuliers (base et intermédiaire principalement)
        PlanService::factory()
            ->count(5)
            ->particulier()
            ->actif()
            ->create();

        // Plans pour entreprises (intermédiaire et premium)
        PlanService::factory()
            ->count(8)
            ->entreprise()
            ->actif()
            ->create();

        // Plans basiques variés
        PlanService::factory()
            ->count(4)
            ->basique()
            ->actif()
            ->create();

        // Plans standards variés
        PlanService::factory()
            ->count(5)
            ->standard()
            ->actif()
            ->create();

        // Plans premium variés
        PlanService::factory()
            ->count(4)
            ->premium()
            ->actif()
            ->create();

        // Plans entreprise variés
        PlanService::factory()
            ->count(3)
            ->entrepriseLevel()
            ->actif()
            ->create();

        // Quelques plans inactifs pour tester
        PlanService::factory()
            ->count(3)
            ->inactif()
            ->create();
    }
}
