<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover\Tests;

use Ocolin\Pushover\Client;
use PHPUnit\Framework\TestCase;

class LicensesTest extends TestCase
{
    public static Client $client;


    public function testCheck() : void
    {
        $output = self::$client->licenses()->check();
        //print_r( $output );
        self::assertIsObject( $output );
        self::assertObjectHasProperty( 'status', $output );
        self::assertEquals( 1, $output->status );
    }

    public static function setUpBeforeClass(): void
    {
        self::$client = new Client();
    }
}