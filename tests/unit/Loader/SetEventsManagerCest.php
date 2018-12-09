<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Unit\Loader;

use UnitTester;

class SetEventsManagerCest
{
    /**
     * Tests Phalcon\Loader :: setEventsManager()
     *
     * @param UnitTester $I
     *
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2018-11-13
     */
    public function loaderSetEventsManager(UnitTester $I)
    {
        $I->wantToTest("Loader - setEventsManager()");
        $I->skipTest("Need implementation");
    }
}
