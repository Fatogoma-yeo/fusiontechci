<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CloseAppForUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:closeApp';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close app for a specific users';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        User::where('email', 'caissefke@fusiontechci.com')->update(['status' =>'inactive']);
        User::where('email', 'agencefke@fusiontechci.com')->update(['status' =>'inactive']);
    }
}
