<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Endereco;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory(10)->create();
        $enderecos = Endereco::factory(10)->create();

        foreach($users as $user){
            $user->enderecos()->attach($enderecos->random(2)->pluck('id'));
        }
    }
}
