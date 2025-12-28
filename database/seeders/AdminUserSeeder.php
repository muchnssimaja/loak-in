<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@loak-in.test'],
            [
                'name'     => 'Admin LOAK.IN',
                'password' => Hash::make('password123'),
            ]
        );

        $user->is_admin = true;

        if (!$user->email_verified_at) {
            $user->email_verified_at = now();
        }

        $user->save();
    }
}
