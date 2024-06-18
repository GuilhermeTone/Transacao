<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cliente>
 */
class CustomersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private function cnpj()
    {
        return $this->faker->unique()->numerify('##.###.###/####-##');
    }

    private function cpf()
    {
        return $this->faker->unique()->numerify('###.###.###-##');
    }
    public function definition()
    {
        static $tipoUsuario = 'comum';
        $tipoUsuario = ($tipoUsuario === 'comum') ? 'lojista' : 'comum';
        $cpfCnpj = $tipoUsuario === 'comum' ? $this->cpf() : $this->cnpj();

        return [
            'name' => $this->faker->name(),
            'user_type' => $tipoUsuario,
            'email' => $this->faker->unique()->safeEmail(),
            'cpf_cnpj' => $cpfCnpj,
            'password' => bcrypt('password'),
            'balance' => $this->faker->randomFloat(2, 0, 10000),
            
        ];
    }
}
