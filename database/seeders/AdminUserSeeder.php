<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Administrador FICCT',
            'email' => 'admin@ficct.uagrm.edu',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Docente Test',
            'email' => 'docente@ficct.uagrm.edu',
            'password' => Hash::make('docente123'),
            'role' => 'docente',
        ]);

        User::create([
            'name' => 'Estudiante Test',
            'email' => 'estudiante@test.com',
            'password' => Hash::make('estudiante123'),
            'role' => 'estudiante',
        ]);
    }
}