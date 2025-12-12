<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover\Tests;

use Ocolin\Pushover\HTTP;
use PHPUnit\Framework\TestCase;

class HttpGetTest extends TestCase {

    public static HTTP $http;

    public function testGetGroups() : void
    {
        $output = self::$http->get(
            uri: 'groups.json'
        );
        self::assertIsObject( $output );
        self::assertObjectHasProperty( 'status', $output );
        self::assertObjectHasProperty( 'status_message', $output );
        self::assertObjectHasProperty( 'headers', $output );
        self::assertObjectHasProperty( 'body', $output );
        self::assertEquals( 200, $output->status );
        //print_r( $output );
    }


    public static function setUpBeforeClass(): void {
        self::$http = new HTTP(
              url: $_ENV['PUSHOVER_API_URL'],
            token: $_ENV['PUSHOVER_API_TOKEN']
        );
    }
}