<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Integration\Validation\Validator\Uniqueness;

use Phalcon\Test\Fixtures\Traits\ValidationTrait;
use Phalcon\Validation\Validator\Uniqueness;
use IntegrationTester;

class HasOptionCest
{
    use ValidationTrait;

    /**
     * Tests Phalcon\Validation\Validator\Uniqueness :: hasOption()
     *
     * @param IntegrationTester $I
     *
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2018-11-13
     */
    public function validationValidatorUniquenessHasOption(IntegrationTester $I)
    {
        $I->wantToTest("Validation\Validator\Uniqueness - hasOption()");
        $validator = new Uniqueness(['message' => 'This is a message']);
        $this->checkHasOption($I, $validator);
    }
}
