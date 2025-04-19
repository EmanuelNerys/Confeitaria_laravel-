<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bakery>
 */
class BakeryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company, // Nome aleatório de uma confeitaria
            'address' => $this->faker->streetAddress, // Endereço aleatório
            'city' => $this->faker->city, // Cidade aleatória
            'state' => $this->faker->state, // Estado aleatório
            'zip_code' => $this->faker->postcode, // CEP aleatório
            'phone' => $this->faker->phoneNumber, // Telefone aleatório
        ];
    }
}
