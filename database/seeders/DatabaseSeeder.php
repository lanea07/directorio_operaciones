<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $user = \App\Models\User::factory()->create([
            'name' => 'Juan Camilo Soto Pineda',
            'email' => 'juancamilo.soto@outlook.com',
            'password' => '$2y$10$1t0XhFHcUO5aHaFuEjHcA.D13QQdmh3DmuWjIxL3Vt0CsndTULaPW',
        ]);

        $role = \App\Models\Role::create([
            'name' => 'administrador',
        ]);

        $user->roles()->attach($role);
    }
}
