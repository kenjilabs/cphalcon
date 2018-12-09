<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Integration\Session\Adapter;

use IntegrationTester;
use Phalcon\Session\Adapter\Libmemcached;

class LibmemcachedCest
{
    /**
     * executed before each test
     */
    public function _before(IntegrationTester $I)
    {
        $I->checkExtensionIsLoaded('redis');

        if (!isset($_SESSION)) {
            $_SESSION = [];
        }
    }

    /**
     * executed after each test
     */
    public function _after(IntegrationTester $I)
    {
        if (PHP_SESSION_ACTIVE == session_status()) {
            session_destroy();
        }
    }

    /**
     * Tests read and write
     *
     * @author Sid Roberts <sid@sidroberts.co.uk>
     * @since  2015-07-17
     */
    public function testReadAndWriteSession(IntegrationTester $I)
    {
        $sessionID = "abcdef123456";
        $session = new Libmemcached([
            'servers' => [
                [
                    'host' => env('DATA_MEMCACHED_HOST'),
                    'port' => env('DATA_MEMCACHED_PORT'),
                ]
            ],
            'client' => []
        ]);
        $data = serialize(
            [
                'abc' => '123',
                'def' => '678',
                'xyz' => 'zyx'
            ]
        );

        $session->write($sessionID, $data);

        $I->assertEquals($session->read($sessionID), $data);
    }

    /**
     * Tests the destroy
     *
     * @author Sid Roberts <sid@sidroberts.co.uk>
     * @since  2015-07-17
     */
    public function testDestroySession(IntegrationTester $I)
    {
        $sessionID = "abcdef123456";
        $session = new Libmemcached([
            'servers' => [
                [
                    'host' => env('DATA_MEMCACHED_HOST'),
                    'port' => env('DATA_MEMCACHED_PORT'),
                ]
            ],
            'client' => []
        ]);
        $data = serialize(
            [
                'abc' => '123',
                'def' => '678',
                'xyz' => 'zyx'
            ]
        );

        $session->write($sessionID, $data);
        $session->destroy($sessionID);

        $I->assertEquals($session->read($sessionID), null);
    }

    /**
     * Tests the destroy with cleanning $_SESSION
     *
     * @test
     * @issue  https://github.com/phalcon/cphalcon/issues/12326
     * @issue  https://github.com/phalcon/cphalcon/issues/12835
     * @author Serghei Iakovelev <serghei@phalconphp.com>
     * @since  2017-05-08
     */
    public function destroyDataFromSessionSuperGlobal(IntegrationTester $I)
    {
        $session = new Libmemcached([
            'servers'  => [
                [
                    'host' => env('DATA_MEMCACHED_HOST'),
                    'port' => env('DATA_MEMCACHED_PORT'),
                ],
            ],
            'client'   => [],
            'uniqueId' => 'session',
            'lifetime' => 3600,
        ]);

        $session->start();

        $session->test1 = __METHOD__;
        $I->assertArrayHasKey('session#test1', $_SESSION);
        $I->assertContains(__METHOD__, $_SESSION['session#test1']);

        $session->destroy();
        $I->assertArrayNotHasKey('session#test1', $_SESSION);
    }
}
