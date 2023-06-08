<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class OpenAppForUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:openApp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Open app for all users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::where('email', 'caissefke@fusiontechci.com')->update(['status' =>'active']);
        User::where('email', 'agencefke@fusiontechci.com')->update(['status' =>'active']);
    }
}
