<?php

namespace Database\Seeders;

use App\Models\DepartmentModel;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DepartmentAndUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            ['name' => 'Tecnologia da Informação'],
            ['name' => 'Recursos Humanos'],
        ];

        foreach ($departments as $deptData) {
            $department = DepartmentModel::create($deptData);

            // Criar 2 usuários para cada departamento
            for ($i = 1; $i <= 2; $i++) {
                $deptNameSlug = strtolower(str_replace(' ', '.', $deptData['name']));
                User::create([
                    'name' => "Usuário {$i} do " . $deptData['name'],
                    'email' => "user{$i}.{$deptNameSlug}@example.com",
                    'password' => Hash::make('password'),
                    'department_id' => $department->id,
                ]);
            }
        }
    }
}
