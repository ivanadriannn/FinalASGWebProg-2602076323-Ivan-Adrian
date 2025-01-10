<?php

namespace Database\Seeders;

use App\Models\FieldOfWork;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldOfWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            'AI & Machine Learning',
            'Cybersecurity',
            'Cloud Computing',
            'Blockchain Development',
            'UX/UI Design',
            'Digital Marketing',
            'Growth Hacking',
            'Product Design',
            'Sustainable Engineering',
            'FinTech Innovation',
        ];

        foreach ($fields as $field) {
            FieldOfWork::create(['name' => $field]);
        }
    }
}
