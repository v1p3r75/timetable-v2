<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Role;
use App\Models\User;
use DB;
use Hash;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        DB::table('roles')->insert([
            ['id' => Role::CENSOR, 'label' => "Censeur"],
            ['id' => Role::DEPUTY_CENSOR, 'label' => "Censeur Adjoint"],
            ['id' => Role::DIRECTOR, 'label' => "Proviseur"],
            ['id' => Role::TEACHER, 'label' => "Enseignant"],
            ['id' => Role::STUDENT, 'label' => "Elève"]
        ]);

        DB::table('users')->insert([
            [
                'firstname' => 'Doe',
                'lastname' => 'John',
                'email' => 'johndoe@example.com',
                'phone' => '12345748',
                'serial_number' => '23GG339L',
                'password' => Hash::make('admin007'),
                'role_id' => Role::CENSOR
            ]
        ]);

        DB::table('users')->insert([
            [
                'firstname' => 'Kabirou',
                'lastname' => 'ALASSANE',
                'email' => 'teacher@example.com',
                'serial_number' => 'MSE3339L',
                'phone' => '34345748',
                'role_id' => Role::TEACHER,
                'password' => Hash::make('prof')
            ]
        ]);

        DB::table('levels')->insert([
            [
                'label' => '2nd IMI',
                'total_students' => 15
            ]
        ]);

        DB::table('classrooms')->insert([
            [
                'label' => 'Salle Informatique',
                'capacity' => '30',
                'status' => true,
            ]
        ]);

        DB::table('subjects')->insert([
            [
                'code' => '2355KKL',
                'label' => 'Algorithme',
                'level_id' => 1
            ]
        ]);
    }
}
