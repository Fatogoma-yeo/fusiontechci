<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\EmailAccount;

class EmailAccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $emails = [
            'comptabilite@fusiontechci.com',
            'servicecommercial@fusiontechci.com',
            'caissefke@fusiontechci.com',
            'agencefke@fusiontechci.com',
        ];

        foreach ($emails as $email) {
            EmailAccount::create(['email' => $email]);
        }
    }
}
