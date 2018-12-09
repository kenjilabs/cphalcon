<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Cli\Cli\Router;

use CliTester;

class GetModuleNameCest
{
    /**
     * Tests Phalcon\Cli\Router :: getModuleName()
     *
     * @param CliTester $I
     *
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2018-11-13
     */
    public function cliRouterGetModuleName(CliTester $I)
    {
        $I->wantToTest("Cli\Router - getModuleName()");
        $I->skipTest("Need implementation");
    }
}
