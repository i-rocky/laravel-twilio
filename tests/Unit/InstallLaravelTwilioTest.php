<?php

namespace Rocky\LaravelTwilio\Tests\Unit;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Rocky\LaravelTwilio\Tests\TestCase;

class InstallLaravelTwilioTest extends TestCase
{
    /** @test */
    public function the_install_command_copies_a_configuration_file()
    {
        if (File::exists(config_path('laravel-twilio.php'))) {
            File::delete(config_path('laravel-twilio.php'));
        }

        $this->assertFalse(File::exists(config_path('laravel-twilio.php')));

        Artisan::call('laravel-twilio:install');

        $this->assertTrue(File::exists(config_path('laravel-twilio.php')));
    }
}
