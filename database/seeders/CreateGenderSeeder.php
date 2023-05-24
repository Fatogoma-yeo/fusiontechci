<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gender;

class CreateGenderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $genders = [
            'Particulier',
            'Entreprise',
        ];

        foreach ($genders as $gender) {
            Gender::create(['name' => $gender]);
        }
    }
}
