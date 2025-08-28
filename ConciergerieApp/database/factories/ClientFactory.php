<?php

namespace Database\Factories;

use App\Models\Client;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => $this->faker->lastName(),
            'prenom' => $this->faker->firstName(),
            'email' => $this->faker->unique()->safeEmail(),
            'telephone' => $this->faker->phoneNumber(),
            'adresse' => $this->faker->address(),
            'date_inscription' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'type_client' => $this->faker->randomElement(['particulier', 'entreprise']),
            'actif' => $this->faker->boolean(80), // 80% de chances d'être actif
        ];
    }

    /**
     * Indicate that the client is a particulier.
     */
    public function particulier(): static
    {
        return $this->state(fn (array $attributes) => [
            'type_client' => 'particulier',
        ]);
    }

    /**
     * Indicate that the client is an entreprise.
     */
    public function entreprise(): static
    {
        return $this->state(fn (array $attributes) => [
            'type_client' => 'entreprise',
        ]);
    }

    /**
     * Indicate that the client is active.
     */
    public function actif(): static
    {
        return $this->state(fn (array $attributes) => [
            'actif' => true,
        ]);
    }

    /**
     * Indicate that the client is inactive.
     */
    public function inactif(): static
    {
        return $this->state(fn (array $attributes) => [
            'actif' => false,
        ]);
    }

    /**
     * Create a client with recent creation date.
     */
    public function recent(): static
    {
        return $this->state(fn (array $attributes) => [
            'date_inscription' => $this->faker->dateTimeBetween('-30 days', 'now'),
        ]);
    }

    /**
     * Create a client with old creation date.
     */
    public function ancien(): static
    {
        return $this->state(fn (array $attributes) => [
            'date_inscription' => $this->faker->dateTimeBetween('-2 years', '-6 months'),
        ]);
    }
}
