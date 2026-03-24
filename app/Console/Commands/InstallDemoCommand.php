<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class InstallDemoCommand extends Command
{
    protected $signature = 'demo:install
                            {--fresh : Run migrate:fresh then seed (wipes all data)}
                            {--force : Required with --fresh in production to confirm wipe}';

    protected $description = 'Reset the database and load demo users (admin + test accounts).';

    public function handle(): int
    {
        if (! $this->option('fresh')) {
            $this->error('Use --fresh to wipe the database and install demo data.');
            $this->line('Example: php artisan demo:install --fresh');
            $this->line('Production: php artisan demo:install --fresh --force');

            return self::FAILURE;
        }

        if (app()->environment('production') && ! $this->option('force')) {
            $this->error('In production, add --force to confirm you want to wipe the database.');
            $this->line('Run: php artisan demo:install --fresh --force');

            return self::FAILURE;
        }

        $this->warn('This will delete all data and re-run migrations + DatabaseSeeder.');

        $this->call('migrate:fresh', [
            '--seed' => true,
            '--force' => true,
        ]);

        $this->info('Demo data installed.');
        $this->table(
            ['Role', 'Email', 'Password'],
            [
                ['Admin', 'admin@bankapp.com', 'password'],
                ['Demo user', 'demo@bankapp.com', 'password'],
                ['Tax alert', 'tax@bankapp.com', 'password'],
                ['Frozen account', 'frozen@bankapp.com', 'password'],
                ['Withheld funds', 'withheld@bankapp.com', 'password'],
                ['Complex scenario', 'complex@bankapp.com', 'password'],
                ['High balance', 'premium@bankapp.com', 'password'],
            ]
        );
        $this->warn('Change passwords after testing in production.');

        return self::SUCCESS;
    }
}
