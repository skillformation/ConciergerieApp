<?php

namespace Database\Factories;

use App\Models\Abonnement;
use App\Models\Client;
use App\Models\PlanService;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Abonnement>
 */
class AbonnementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Abonnement::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Générer une date de début dans les 6 derniers mois
        $dateDebut = $this->faker->dateTimeBetween('-6 months', 'now');
        
        // Générer une date de fin entre 1 mois et 2 ans après la date de début
        $dateFin = $this->faker->dateTimeBetween(
            $dateDebut->format('Y-m-d') . ' +1 month',
            $dateDebut->format('Y-m-d') . ' +2 years'
        );

        // Définir les statuts possibles avec leurs probabilités
        $statuts = [
            'actif' => 60,      // 60% de chances
            'suspendu' => 10,   // 10% de chances
            'expiré' => 20,     // 20% de chances
            'annulé' => 10      // 10% de chances
        ];

        // Modes de paiement avec leurs probabilités
        $modesPaiement = [
            'carte_credit' => 50,
            'virement' => 30,
            'paypal' => 15,
            'cheque' => 5
        ];

        return [
            'id_client' => Client::factory(),
            'id_plan' => PlanService::factory(),
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
            'statut' => $this->faker->randomElement(
                array_merge(...array_map(
                    fn($statut, $poids) => array_fill(0, $poids, $statut),
                    array_keys($statuts),
                    $statuts
                ))
            ),
            'prix_actuel' => $this->faker->randomFloat(2, 9.99, 999.99),
            'mode_paiement' => $this->faker->randomElement(
                array_merge(...array_map(
                    fn($mode, $poids) => array_fill(0, $poids, $mode),
                    array_keys($modesPaiement),
                    $modesPaiement
                ))
            ),
        ];
    }

    /**
     * Configure l'abonnement pour utiliser un client existant.
     */
    public function forClient(Client $client): static
    {
        return $this->state(fn (array $attributes) => [
            'id_client' => $client->id_client,
        ]);
    }

    /**
     * Configure l'abonnement pour utiliser un plan existant.
     */
    public function forPlan(PlanService $plan): static
    {
        return $this->state(fn (array $attributes) => [
            'id_plan' => $plan->id_plan,
            'prix_actuel' => $plan->prix_mensuel, // Utiliser le prix du plan
        ]);
    }

    /**
     * Abonnement actif.
     */
    public function actif(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => 'actif',
            'date_debut' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'date_fin' => $this->faker->dateTimeBetween('now + 1 month', 'now + 2 years'),
        ]);
    }

    /**
     * Abonnement suspendu.
     */
    public function suspendu(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut' => 'suspendu',
        ]);
    }

    /**
     * Abonnement expiré.
     */
    public function expire(): static
    {
        $dateDebut = $this->faker->dateTimeBetween('-2 years', '-1 month');
        $dateFin = $this->faker->dateTimeBetween($dateDebut, 'now - 1 day');

        return $this->state(fn (array $attributes) => [
            'statut' => 'expiré',
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
        ]);
    }

    /**
     * Abonnement annulé.
     */
    public function annule(): static
    {
        $dateDebut = $this->faker->dateTimeBetween('-1 year', '-1 month');
        $dateFin = $this->faker->dateTimeBetween($dateDebut, 'now');

        return $this->state(fn (array $attributes) => [
            'statut' => 'annulé',
            'date_debut' => $dateDebut,
            'date_fin' => $dateFin,
        ]);
    }

    /**
     * Abonnement récent (commencé dans les 30 derniers jours).
     */
    public function recent(): static
    {
        $dateDebut = $this->faker->dateTimeBetween('-30 days', 'now');

        return $this->state(fn (array $attributes) => [
            'date_debut' => $dateDebut,
            'date_fin' => $this->faker->dateTimeBetween(
                $dateDebut->format('Y-m-d') . ' +1 month',
                $dateDebut->format('Y-m-d') . ' +1 year'
            ),
            'statut' => 'actif',
        ]);
    }

    /**
     * Abonnement long terme (plus d'un an).
     */
    public function longTerme(): static
    {
        $dateDebut = $this->faker->dateTimeBetween('-2 years', '-6 months');
        
        return $this->state(fn (array $attributes) => [
            'date_debut' => $dateDebut,
            'date_fin' => $this->faker->dateTimeBetween('now + 6 months', 'now + 2 years'),
            'statut' => $this->faker->randomElement(['actif', 'suspendu']),
        ]);
    }

    /**
     * Abonnement avec prix personnalisé.
     */
    public function avecPrix(float $prix): static
    {
        return $this->state(fn (array $attributes) => [
            'prix_actuel' => $prix,
        ]);
    }

    /**
     * Abonnement avec mode de paiement spécifique.
     */
    public function avecModePaiement(string $mode): static
    {
        return $this->state(fn (array $attributes) => [
            'mode_paiement' => $mode,
        ]);
    }
}