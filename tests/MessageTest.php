<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover\Tests;

use Ocolin\Pushover\Client;
use PHPUnit\Framework\TestCase;

class MessageTest extends TestCase
{
    public static Client $client;

    public function testPushMessage() : void
    {
        $output = self::$client->message()->push(
            user: $_ENV['TEST_USER'],
            message: "This is a test message",
            options: [ 'title' => 'This is a title' ]
        );
        self::assertIsObject( $output );
        self::assertObjectHasProperty( 'status', $output );
        self::assertObjectHasProperty( 'request', $output );
        self::assertEquals( 1, $output->status );
        //print_r( $output );
    }

    public static function setUpBeforeClass(): void
    {
        self::$client = new Client();
    }
}