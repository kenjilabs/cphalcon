<?php

namespace Phalcon\Test\Unit\Http\Response;

use Phalcon\Di;
use Phalcon\Http\Cookie;
use Phalcon\Http\CookieInterface;
use Phalcon\Http\Response;
use Phalcon\Http\Response\Cookies;
use Phalcon\Session\Manager as SessionManager;
use Phalcon\Session\Adapter\Files as SessionFiles;
use Phalcon\Test\Unit\Http\Helper\HttpBase;
use UnitTester;

/**
 * Phalcon\Test\Unit\Http\Response\Http\CookiesTest
 * Tests the Phalcon\Http\Response\Cookies component
 *
 * @copyright (c) 2011-2017 Phalcon Team
 * @link          https://phalconphp.com
 * @author        Andres Gutierrez <andres@phalconphp.com>
 * @author        Phalcon Team <team@phalconphp.com>
 * @package       Phalcon\Test\Unit\Http\Response
 *
 * The contents of this file are subject to the New BSD License that is
 * bundled with this package in the file LICENSE.txt
 *
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world-wide-web, please send an email to license@phalconphp.com
 * so that we can send you a copy immediately.
 */
class CookiesCest extends HttpBase
{
    /**
     * Tests the internal cookies property.
     *
     * @test
     * @issue  https://github.com/phalcon/cphalcon/issues/12978
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2017-09-02
     */
    public function shouldWorkWithoutInitializeInternalCookiesProperty(UnitTester $I)
    {
        $I->assertTrue((new Cookies())->send());
    }

    /**
     * Tests getCookies is work.
     *
     * @author limx <715557344@qq.com>
     */
    public function testGetCookies(UnitTester $I)
    {
        $cookies = new Cookies();

        Di::reset();
        $di = new Di();
        $di->set('response', function () {
            return new Response();
        });
        $di->set('session', function () {
            $manager = new SessionManager();
            $adapter = new SessionFiles();
            $manager->setHandler($adapter);

            return $manager;
        });

        $cookies->setDI($di);

        $cookies->set('x-token', '1bf0bc92ed7dcc80d337a5755f879878');
        $cookies->set('x-user-id', 1);

        $I->assertTrue(is_array($cookies->getCookies()));

        $cookieArray = $cookies->getCookies();
        $I->assertInstanceOf(CookieInterface::class, $cookieArray['x-token']);
        $I->assertInstanceOf(CookieInterface::class, $cookieArray['x-user-id']);

        /** @var Cookie[] $cookieArray */
        $cookieArray = $cookies->getCookies();
        $I->assertEquals('1bf0bc92ed7dcc80d337a5755f879878', $cookieArray['x-token']);
        $I->assertEquals(1, $cookieArray['x-user-id']->getValue());
    }
}
