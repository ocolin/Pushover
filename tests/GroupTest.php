<?php

declare( strict_types = 1 );

namespace Ocolin\Pushover\Tests;

use Ocolin\Pushover\Client;
use PHPUnit\Framework\TestCase;

class GroupTest extends TestCase
{
    public static Client $client;

    public static string $group_id;


    public function testGetGroups() : void
    {
        $output = self::$client->groups()->groups();
        //print_r( $output );
        self::assertIsObject( $output );
        self::assertObjectHasProperty( 'groups', $output );
        self::assertObjectHasProperty( 'request', $output );
        self::assertObjectHasProperty( 'status', $output );
        self::assertIsArray( $output->groups );
        self::assertEquals( 1, $output->status );
    }

/*
    public function testCreateGroup() : void
    {
        $output = self::$client->groups()->create( name: 'PHPUnit Test Group' );
        //print_r( $output );
        self::$group_id = $output->group;
        self::assertIsObject( $output );
        self::assertObjectHasProperty( 'groups', $output );
        self::assertObjectHasProperty( 'request', $output );
        self::assertObjectHasProperty( 'status', $output );
        self::assertEquals( 1, $output->status );
    }
*/

    public function testGetGroup() : void
    {
        $output = self::$client->groups()->get( $_ENV['TEST_GROUP'] );
        //print_r( $output );
        self::assertIsObject( $output );
        self::assertObjectHasProperty( 'status', $output );
        self::assertEquals( 1, $output->status );
    }

    public function testAddUser() : void
    {
        $output = self::$client->groups()->addUser(
            group: $_ENV['TEST_GROUP'],
            user: $_ENV['TEST_USER']
        );
        //print_r( $output );
        self::assertIsObject( $output );
        self::assertObjectHasProperty( 'status', $output );
        self::assertEquals( 1, $output->status );
    }

    public function testDisableUser() : void
    {
        $output = self::$client->groups()->disableUser(
            group: $_ENV['TEST_GROUP'],
            user: $_ENV['TEST_USER']
        );
        //print_r( $output );
        self::assertIsObject( $output );
        self::assertObjectHasProperty( 'status', $output );
        self::assertEquals( 1, $output->status );
    }

    public function testEnableUser() : void
    {
        $output = self::$client->groups()->enableUser(
            group: $_ENV['TEST_GROUP'],
            user: $_ENV['TEST_USER']
        );
        //print_r( $output );
        self::assertIsObject( $output );
        self::assertObjectHasProperty( 'status', $output );
        self::assertEquals( 1, $output->status );
    }

    public function testRemoveUser() : void
    {
        $output = self::$client->groups()->removeUser(
            group: $_ENV['TEST_GROUP'],
            user: $_ENV['TEST_USER']
        );
        //print_r( $output );
        self::assertIsObject( $output );
        self::assertObjectHasProperty( 'status', $output );
        self::assertEquals( 1, $output->status );
    }

    public function testRenameGroup() : void
    {
        $output = self::$client->groups()->rename(
            group: $_ENV['TEST_GROUP'],
            name: 'New Name'
        );
        print_r( $output );
        self::assertIsObject( $output );
        self::assertObjectHasProperty( 'status', $output );
        self::assertEquals( 1, $output->status );
    }

    public static function setUpBeforeClass(): void
    {
        self::$client = new Client();
    }
}