<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Unit\Http\Request\File;

use UnitTester;

class GetErrorCest
{
    /**
     * Tests Phalcon\Http\Request\File :: getError()
     *
     * @param UnitTester $I
     *
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2018-11-13
     */
    public function httpRequestFileGetError(UnitTester $I)
    {
        $I->wantToTest("Http\Request\File - getError()");
        $I->skipTest("Need implementation");
    }
}
