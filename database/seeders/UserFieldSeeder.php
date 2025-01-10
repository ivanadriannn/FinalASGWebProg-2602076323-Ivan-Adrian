<?php

namespace Database\Seeders;

use App\Models\UserField;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $users = [
            1 => [1, 2, 8],
            2 => [4, 6, 9],
            3 => [5, 7, 9],
            4 => [1, 5, 7],
            5 => [1, 2, 3],
            6 => [1, 3, 5],
            7 => [2, 3, 7],
            8 => [4, 6, 8],
            9 => [1, 3, 7],
            10 => [2, 3, 5],
            11 => [3, 7, 8],
            12 => [1, 3, 4],
            13 => [1, 5, 4],
            14 => [3, 4, 5],
            15 => [1, 2, 4],
        ];

        foreach ($users as $userId => $fieldIds) {
            foreach ($fieldIds as $fieldId) {
                UserField::create([
                    'user_id' => $userId,
                    'field_of_work_id' => $fieldId,
                ]);
            }
        }
    }
}
