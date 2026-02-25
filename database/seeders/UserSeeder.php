<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rol1 = Role::create([
            'id'=>1,
            'nombre' => 'administrador',
            'estado' => 'activo',
            'descripcion' => 'administrador'
        ]);

        $rol2 = Role::create([
            'id'=>2,
            'nombre' => 'usuario general',
            'estado' => 'activo',
            'descripcion' => 'general'
        ]);


        $user1 = User::create([
            'id'=>1,
            'name' => 'Perlux',
            'email' => 'admin@perlux.com',
            'tipo' => 'normal',
            'password' => bcrypt('admin123'), 
            'photo_url' => '/images/user_black.svg',
            'estado' => 'activo',
            'role_id' => 1, 
        ]);
    }
}
