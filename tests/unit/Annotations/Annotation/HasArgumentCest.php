<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Unit\Annotations\Annotation;

use UnitTester;

class HasArgumentCest
{
    /**
     * Tests Phalcon\Annotations\Annotation :: hasArgument()
     *
     * @param UnitTester $I
     *
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2018-11-13
     */
    public function annotationsAnnotationHasArgument(UnitTester $I)
    {
        $I->wantToTest("Annotations\Annotation - hasArgument()");
        $I->skipTest("Need implementation");
    }
}
