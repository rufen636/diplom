<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class CreateRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Role::updateOrCreate(['name' => 'manager']);
        Role::updateOrCreate(['name' => 'buh']);
        Role::updateOrCreate(['name' => 'sysadmin']);
    }
}
