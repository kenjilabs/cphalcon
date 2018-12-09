<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Unit\Http\Response;

use UnitTester;

class SendHeadersCest
{
    /**
     * Tests Phalcon\Http\Response :: sendHeaders()
     *
     * @param UnitTester $I
     *
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2018-11-13
     */
    public function httpResponseSendHeaders(UnitTester $I)
    {
        $I->wantToTest("Http\Response - sendHeaders()");
        $I->skipTest("Need implementation");
    }
}
