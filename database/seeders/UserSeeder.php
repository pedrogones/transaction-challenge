<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Root',
                'email' => 'root@root.com',
                'password' => Hash::make('123123'),
                'email_verified_at' => now(),
                'role' => 'Admin',
            ],
            [
                'name' => 'Pedro Targino Gomes',
                'email' => 'pedro@financeiro.com',
                'password' => Hash::make('123123'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Emilly Fontes de Lemos Silva',
                'email' => 'emilly@financeiro.com',
                'password' => Hash::make('123123'),
                'email_verified_at' => now(),
                'role' => 'User',
            ],
            [
                'name' => 'Victor Souza',
                'email' => 'victor@financeiro.com',
                'password' => Hash::make('123123'),
                'email_verified_at' => now(),
                'role' => 'User',
            ],
            [
                'name' => 'Samuel Fernandes',
                'email' => 'samuel@financeiro.com',
                'password' => Hash::make('123123'),
                'email_verified_at' => now(),
                'role' => 'User',
            ],
            [
                'name' => 'Adriana Cristina Targino',
                'email' => 'adriana@financeiro.com',
                'password' => Hash::make('123123'),
                'email_verified_at' => now(),
                'role' => 'User',
            ],
        ];

        foreach ($users as $user){

            $role = $user['role'] ?? 'User';
            unset($user['role']);

            $user = User::updateOrCreate(['email' => $user['email']], $user);

            $user->syncRoles([$role]);

        }
    }
}
