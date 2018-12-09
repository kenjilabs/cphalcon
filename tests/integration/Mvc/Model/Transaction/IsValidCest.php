<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Integration\Mvc\Model\Transaction;

use IntegrationTester;

class IsValidCest
{
    /**
     * Tests Phalcon\Mvc\Model\Transaction :: isValid()
     *
     * @param IntegrationTester $I
     *
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2018-11-13
     */
    public function mvcModelTransactionIsValid(IntegrationTester $I)
    {
        $I->wantToTest("Mvc\Model\Transaction - isValid()");
        $I->skipTest("Need implementation");
    }
}
