<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PerfilFactory extends Factory
{
    /**
     * @return array
     */
    public function definition()
    {
        return [
            'nome_perfil' => $this->faker->word(),
            'flg_perfil_ativo' => 1,
        ];
    }
}
