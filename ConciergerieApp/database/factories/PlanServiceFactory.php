<?php

namespace Database\Factories;

use App\Models\PlanService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PlanService>
 */
class PlanServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PlanService::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Utilisation des valeurs ENUM définies dans la migration
        $niveaux = ['basique', 'standard', 'premium', 'entreprise'];
        $targets = ['particulier', 'entreprise', 'mixte'];
        
        $niveau = $this->faker->randomElement($niveaux);
        
        return [
            'nom_plan' => $this->generatePlanName($niveau),
            'prix_mensuel' => $this->generatePrice($niveau),
            'description' => $this->generateDescription($niveau),
            'niveau_service' => $niveau,
            'target' => $this->faker->randomElement($targets),
            'positionnement' => $this->generatePositioning($niveau),
            'actif' => $this->faker->boolean(85), // 85% de chances d'être actif
        ];
    }

    /**
     * Génère un nom de plan basé sur le niveau
     */
    private function generatePlanName(string $niveau): string
    {
        $noms = [
            'basique' => ['Starter', 'Essentiel', 'Basic', 'Découverte', 'Simple'],
            'standard' => ['Standard', 'Professionnel', 'Plus', 'Avancé', 'Business'],
            'premium' => ['Premium', 'Expert', 'Pro+', 'Superieur', 'Elite'],
            'entreprise' => ['Enterprise', 'Corporate', 'Business+', 'Professional']
        ];
        
        return $this->faker->randomElement($noms[$niveau] ?? ['Plan']);
    }

    /**
     * Génère un prix basé sur le niveau
     */
    private function generatePrice(string $niveau): float
    {
        $ranges = [
            'basique' => [9.99, 39.99],
            'standard' => [39.99, 119.99],
            'premium' => [119.99, 499.99],
            'entreprise' => [499.99, 1999.99]
        ];
        
        $range = $ranges[$niveau] ?? [50, 100];
        return $this->faker->randomFloat(2, $range[0], $range[1]);
    }

    /**
     * Génère une description basée sur le niveau
     */
    private function generateDescription(string $niveau): string
    {
        $descriptions = [
            'basique' => [
                'Plan d\'entrée idéal pour débuter',
                'Fonctionnalités essentielles pour commencer',
                'Solution simple et économique',
                'Parfait pour les petites structures'
            ],
            'standard' => [
                'Plan équilibré avec toutes les fonctionnalités principales',
                'Solution complète pour les besoins courants',
                'Idéal pour la plupart des utilisateurs',
                'Fonctionnalités avancées incluses'
            ],
            'premium' => [
                'Plan haut de gamme avec fonctionnalités premium',
                'Solution complète pour les utilisateurs exigeants',
                'Toutes les fonctionnalités + support prioritaire',
                'Parfait pour maximiser votre productivité'
            ],
            'entreprise' => [
                'Solution sur mesure pour les grandes entreprises',
                'Support dédié et fonctionnalités enterprise',
                'Intégration complète et personnalisation avancée',
                'SLA garantie et support 24/7'
            ]
        ];
        
        return $this->faker->randomElement($descriptions[$niveau] ?? ['Description du plan']);
    }

    /**
     * Génère un positionnement basé sur le niveau
     */
    private function generatePositioning(string $niveau): string
    {
        $positionnements = [
            'basique' => [
                'Économique et accessible',
                'Simple et efficace',
                'Solution d\'entrée',
                'Rapport qualité-prix optimal'
            ],
            'standard' => [
                'Le choix le plus populaire',
                'Équilibre parfait fonctionnalités-prix',
                'Recommandé pour la plupart des cas',
                'Solution polyvalente'
            ],
            'premium' => [
                'Haut de gamme et performant',
                'Pour les utilisateurs exigeants',
                'Maximum de fonctionnalités',
                'Excellence et performance'
            ],
            'entreprise' => [
                'Solution enterprise complète',
                'Dédiée aux grandes organisations',
                'Support et intégration premium',
                'Sécurité et performance maximales'
            ]
        ];
        
        return $this->faker->randomElement($positionnements[$niveau] ?? ['Positionnement standard']);
    }

    /**
     * Plan pour particuliers
     */
    public function particulier(): static
    {
        return $this->state(fn (array $attributes) => [
            'target' => 'particulier',
            'niveau_service' => $this->faker->randomElement(['basique', 'standard']),
        ]);
    }

    /**
     * Plan pour entreprises
     */
    public function entreprise(): static
    {
        return $this->state(fn (array $attributes) => [
            'target' => 'entreprise',
            'niveau_service' => $this->faker->randomElement(['standard', 'premium', 'entreprise']),
        ]);
    }

    /**
     * Plan basique
     */
    public function basique(): static
    {
        return $this->state(fn (array $attributes) => [
            'niveau_service' => 'basique',
            'nom_plan' => $this->faker->randomElement(['Starter', 'Essentiel', 'Basic']),
            'prix_mensuel' => $this->faker->randomFloat(2, 9.99, 39.99),
        ]);
    }

    /**
     * Plan standard
     */
    public function standard(): static
    {
        return $this->state(fn (array $attributes) => [
            'niveau_service' => 'standard',
            'nom_plan' => $this->faker->randomElement(['Standard', 'Professionnel', 'Plus']),
            'prix_mensuel' => $this->faker->randomFloat(2, 39.99, 119.99),
        ]);
    }

    /**
     * Plan premium
     */
    public function premium(): static
    {
        return $this->state(fn (array $attributes) => [
            'niveau_service' => 'premium',
            'nom_plan' => $this->faker->randomElement(['Premium', 'Expert', 'Pro+']),
            'prix_mensuel' => $this->faker->randomFloat(2, 119.99, 499.99),
            'target' => $this->faker->randomElement(['entreprise', 'mixte']),
        ]);
    }

    /**
     * Plan entreprise
     */
    public function entrepriseLevel(): static
    {
        return $this->state(fn (array $attributes) => [
            'niveau_service' => 'entreprise',
            'nom_plan' => $this->faker->randomElement(['Enterprise', 'Corporate', 'Business+']),
            'prix_mensuel' => $this->faker->randomFloat(2, 499.99, 1999.99),
            'target' => 'entreprise',
        ]);
    }

    /**
     * Plan actif
     */
    public function actif(): static
    {
        return $this->state(fn (array $attributes) => [
            'actif' => true,
        ]);
    }

    /**
     * Plan inactif
     */
    public function inactif(): static
    {
        return $this->state(fn (array $attributes) => [
            'actif' => false,
        ]);
    }
}
