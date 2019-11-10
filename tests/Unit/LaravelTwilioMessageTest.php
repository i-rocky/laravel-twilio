<?php

namespace Rocky\LaravelTwilio\Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Rocky\LaravelTwilio\Models\LaravelTwilioMessage;
use Rocky\LaravelTwilio\Tests\TestCase;

class LaravelTwilioMessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function laravel_twilio_message_must_have_a_type()
    {
        /** @var LaravelTwilioMessage $message */
        $message = factory(LaravelTwilioMessage::class)->create([]);
        $this->assertEquals("sms", $message->type);
    }
}
