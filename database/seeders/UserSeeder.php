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
            ],
            [
                'name' => 'Victor Souza',
                'email' => 'victor@financeiro.com',
                'password' => Hash::make('123123'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Samuel Fernandes',
                'email' => 'samuel@financeiro.com',
                'password' => Hash::make('123123'),
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Adriana Cristina Targino',
                'email' => 'adriana@financeiro.com',
                'password' => Hash::make('123123'),
                'email_verified_at' => now(),
            ],
        ];

        foreach ($users as $user){
            User::updateOrCreate(['email' => $user['email']], $user);
        }
    }
}
