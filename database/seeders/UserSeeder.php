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
        User::insert([
            'name' => 'Timur Sahadewa',
            'email' => 'timur.sahadewa@indonesiapower.co.id',
            'password' => Hash::make('admin123'),
            'unit_kd' => 'KP',
            'user_id' => 'timur.sahadewa',
        ]);
    }
}
