<?php

namespace App\Console\Commands;

use App\Services\User\IUserServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Psy\Util\Json;

class SeedingUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SeedingUsers:seedingUsers';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeding Users';

    /**
     * Create a new command instance.
     *
     * @return void
     */

    protected IUserServiceInterface $userService;
    public function __construct(
        IUserServiceInterface $userService
    )
    {
        parent::__construct();
        $this->userService = $userService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
       $user = $this->userService->insertUser();
        if (isset($user['message'])) {
            $this->warn($user['message']);
        } else {
            $this->info('User created: ' . json_encode($user));
        }
    }
}
