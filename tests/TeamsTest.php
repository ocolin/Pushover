<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover\Tests;

use Ocolin\Pushover\Client;
use PHPUnit\Framework\TestCase;

class TeamsTest extends TestCase
{
    public static Client $client;

    public function testShowTeams() : void
    {
        $output = self::$client->teams()->show( token: $_ENV['TEST_TEAM'] );
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