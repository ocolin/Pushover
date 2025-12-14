<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover\Tests;

use Ocolin\Pushover\Client;
use PHPUnit\Framework\TestCase;

class EmergencyTest extends TestCase
{
    public static Client $client;

    public static string $rcpt;

    public function testEmergencyPush() : void
    {
        $output = self::$client->messages()->push(
            user: $_ENV['TEST_USER'],
            message: 'This be an emergency yO!',
            params: [
                'priority' => 2,
                'retry' => 60,
                'expire' => 1800,
                'tags' => 'testtag'
            ]
        );
        //print_r( $output );
        self::$rcpt = $output->receipt;
        self::assertIsObject( $output );
        self::assertObjectHasProperty( 'status', $output );
        self::assertObjectHasProperty( 'request', $output );
        self::assertEquals( 1, $output->status );
    }

    public function testGetReceipt() : void
    {
        $output = self::$client->receipts()->get( receipt: self::$rcpt );
        //print_r( $output );
        self::assertIsObject( $output );
        self::assertObjectHasProperty( 'status', $output );
        self::assertObjectHasProperty( 'request', $output );
        self::assertEquals( 1, $output->status );
    }

/*
    public function testCacnel() : void
    {
        $output = self::$client->receipts()->cancel( receipt: self::$rcpt );
        //print_r( $output );
        self::assertIsObject( $output );
        self::assertObjectHasProperty( 'status', $output );
        self::assertObjectHasProperty( 'request', $output );
        self::assertEquals( 1, $output->status );
    }
*/

    public function testCancelTag() : void
    {
        $output = self::$client->receipts()->cancelByTag( tag: 'testtag' );
        print_r( $output );
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