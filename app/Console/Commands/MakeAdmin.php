<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class MakeAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:admin {UserEmail}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a user Admin';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $user_email = $this->argument('UserEmail');
        User::where('email', $user_email)
        ->update([
            'role_as' => '1'
        ]);
        echo   "User is now an Administrator"; 
    }
}
