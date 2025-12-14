<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover\Tests;

use Ocolin\Pushover\Client;
use PHPUnit\Framework\TestCase;

class LimitsTest extends TestCase
{
    public static Client $client;

    public function testList() : void
    {
        $output = self::$client->apps()->limits();
        //print_r( $output );
        self::assertIsObject( $output );
        self::assertObjectHasProperty( 'status', $output );
        self::assertObjectHasProperty( 'request', $output );
        self::assertEquals( 1, $output->status );
    }

    public static function setUpBeforeClass(): void
    {
        self::$client = new Client();
    }
}