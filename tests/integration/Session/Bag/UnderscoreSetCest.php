<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Integration\Session\Bag;

use IntegrationTester;

class UnderscoreSetCest
{
    /**
     * Tests Phalcon\Session\Bag :: __set()
     *
     * @param IntegrationTester $I
     *
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2018-11-13
     */
    public function sessionBagUnderscoreSet(IntegrationTester $I)
    {
        $I->wantToTest("Session\Bag - __set()");
        $I->skipTest("Need implementation");
    }
}
