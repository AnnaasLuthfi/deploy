<?php

namespace Database\Seeders;

use App\Models\Roles;
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
        $rolesAdmin = Roles::where('name','owner')->first();

        User::create([
            'name' => 'owner',
            'email' => 'owner@owner.com',
            'role_id' => $rolesAdmin->id,
            'password' => Hash::make('password'),
        ]);
    }
}
