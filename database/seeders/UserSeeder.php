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
        User::create([
            'name' => 'Ivan Adrian',
            'email' => 'ivanadrian0864@gmail.com',
            'password' => Hash::make('password123'),
            'gender' => 'male',
            'profession_id' => 3,
            'linkedin' => 'https://www.linkedin.com/in/ivan-adriannn/',
            'mobile_number' => '08979780001',
        ]);

        User::create([
            'name' => 'Ayu Saraswati',
            'email' => 'ayu.saraswati@example.com',
            'password' => Hash::make('password123'),
            'gender' => 'female',
            'profession_id' => 3,
            'linkedin' => 'https://www.linkedin.com/in/ivan-adriannn/',
            'mobile_number' => '08979780002',
        ]);

        User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi.santoso@example.com',
            'password' => Hash::make('password123'),
            'gender' => 'male',
            'profession_id' => 1,
            'linkedin' => 'https://www.linkedin.com/in/ivan-adriannn/',
            'mobile_number' => '08979780003',
        ]);

        User::create([
            'name' => 'Citra Dewi',
            'email' => 'citra.dewi@example.com',
            'password' => Hash::make('password123'),
            'gender' => 'female',
            'profession_id' => 1,
            'linkedin' => 'https://www.linkedin.com/in/ivan-adriannn/',
            'mobile_number' => '08979780004',
        ]);

        User::create([
            'name' => 'Danu Prasetyo',
            'email' => 'danu.prasetyo@example.com',
            'password' => Hash::make('password123'),
            'gender' => 'male',
            'profession_id' => 4,
            'linkedin' => 'https://www.linkedin.com/in/ivan-adriannn/',
            'mobile_number' => '08979780005',
        ]);

        User::create([
            'name' => 'Eka Wulandari',
            'email' => 'eka.wulandari@example.com',
            'password' => Hash::make('password123'),
            'gender' => 'female',
            'profession_id' => 5,
            'linkedin' => 'https://www.linkedin.com/in/ivan-adriannn/',
            'mobile_number' => '08979780006',
        ]);

        User::create([
            'name' => 'Fajar Gunawan',
            'email' => 'fajar.gunawan@example.com',
            'password' => Hash::make('password123'),
            'gender' => 'male',
            'profession_id' => 6,
            'linkedin' => 'https://www.linkedin.com/in/ivan-adriannn/',
            'mobile_number' => '08979780007',
        ]);

        User::create([
            'name' => 'Gita Nuraini',
            'email' => 'gita.nuraini@example.com',
            'password' => Hash::make('password123'),
            'gender' => 'female',
            'profession_id' => 8,
            'linkedin' => 'https://www.linkedin.com/in/ivan-adriannn/',
            'mobile_number' => '08979780008',
        ]);

        User::create([
            'name' => 'Hadi Wirawan',
            'email' => 'hadi.wirawan@example.com',
            'password' => Hash::make('password123'),
            'gender' => 'male',
            'profession_id' => 9,
            'linkedin' => 'https://www.linkedin.com/in/ivan-adriannn/',
            'mobile_number' => '08979780009',
        ]);

        User::create([
            'name' => 'Indah Rahmawati',
            'email' => 'indah.rahmawati@example.com',
            'password' => Hash::make('password123'),
            'gender' => 'female',
            'profession_id' => 9,
            'linkedin' => 'https://www.linkedin.com/in/ivan-adriannn/',
            'mobile_number' => '08979780010',
        ]);

        User::create([
            'name' => 'Joko Sutrisno',
            'email' => 'joko.sutrisno@example.com',
            'password' => Hash::make('password123'),
            'gender' => 'male',
            'profession_id' => 9,
            'linkedin' => 'https://www.linkedin.com/in/ivan-adriannn/',
            'mobile_number' => '08979780011',
        ]);
        
        User::create([
            'name' => 'Kartika Sari',
            'email' => 'kartika.sari@example.com',
            'password' => Hash::make('password123'),
            'gender' => 'female',
            'profession_id' => 4,
            'linkedin' => 'https://www.linkedin.com/in/ivan-adriannn/',
            'mobile_number' => '08979780012',
        ]);

        User::create([
            'name' => 'Budi Raharja',
            'email' => 'budi.raharja@example.com',
            'password' => Hash::make('password123'),
            'gender' => 'male',
            'profession_id' => 1,
            'linkedin' => 'https://www.linkedin.com/in/ivan-adriannn/',
            'mobile_number' => '08987654455',
        ]);
        
        User::create([
            'name' => 'Rina Anggraini',
            'email' => 'rina.anggraini@example.com',
            'password' => Hash::make('password123'),
            'gender' => 'female',
            'profession_id' => 2,
            'linkedin' => 'https://www.linkedin.com/in/ivan-adriannn/',
            'mobile_number' => '08923456789',
        ]);
        
        User::create([
            'name' => 'Joko Wijaya',
            'email' => 'joko.wijaya@example.com',
            'password' => Hash::make('password123'),
            'gender' => 'male',
            'profession_id' => 3,
            'linkedin' => 'https://www.linkedin.com/in/ivan-adriannn/',
            'mobile_number' => '08934211223',
        ]);        
    }
}
