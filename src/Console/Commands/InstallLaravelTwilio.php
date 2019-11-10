<?php

namespace Rocky\LaravelTwilio\Console\Commands;

use Illuminate\Console\Command;
use Rocky\LaravelTwilio\Providers\LaravelTwilioServiceProvider;

class InstallLaravelTwilio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel-twilio:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Installs Laravel Twilio in a Laravel ecosystem';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Installing Laravel Twilio...');

        $this->info('Publishing config...');

        $this->call('vendor:publish', [
            '--provider' => LaravelTwilioServiceProvider::class,
            '--tag'      => 'config',
        ]);

        $this->info('Installed Laravel Twilio');
    }
}
