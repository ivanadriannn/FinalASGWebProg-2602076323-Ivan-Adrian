<?php

namespace Database\Seeders;

use App\Models\Profession;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Profession::create(['name' => 'AI Researcher']);               
        Profession::create(['name' => 'Cybersecurity Specialist']);   
        Profession::create(['name' => 'Cloud Engineer']);             
        Profession::create(['name' => 'Blockchain Developer']);       
        Profession::create(['name' => 'UI/UX Designer']);             
        Profession::create(['name' => 'Digital Marketing Strategist']); 
        Profession::create(['name' => 'Growth Hacker']);              
        Profession::create(['name' => 'Product Designer']);           
        Profession::create(['name' => 'Sustainability Engineer']);  
        Profession::create(['name' => 'FinTech Analyst']);            

    }
}
