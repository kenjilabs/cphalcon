<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Integration\Validation;

use IntegrationTester;

class RulesCest
{
    /**
     * Tests Phalcon\Validation :: rules()
     *
     * @param IntegrationTester $I
     *
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2018-11-13
     */
    public function validationRules(IntegrationTester $I)
    {
        $I->wantToTest("Validation - rules()");
        $I->skipTest("Need implementation");
    }
}
