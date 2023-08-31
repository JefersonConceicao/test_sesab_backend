<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class EnderecoFactory extends Factory
{
    /**
     * @return array
     */
    public function definition()
    {
        return [
            'cep' => $this->faker->numberBetween(00000000,999999999),
            'nome_logradouro' => $this->faker->word(),
            'bairro' => $this->faker->word(),
            'municipio' => $this->faker->word(),
        ];
    }
}
