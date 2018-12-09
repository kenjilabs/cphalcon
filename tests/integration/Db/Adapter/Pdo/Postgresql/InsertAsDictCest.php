<?php

/**
 * This file is part of the Phalcon Framework.
 *
 * (c) Phalcon Team <team@phalconphp.com>
 *
 * For the full copyright and license information, please view the LICENSE.txt
 * file that was distributed with this source code.
 */

namespace Phalcon\Test\Integration\Db\Adapter\Pdo\Postgresql;

use IntegrationTester;

class InsertAsDictCest
{
    /**
     * Tests Phalcon\Db\Adapter\Pdo\Postgresql :: insertAsDict()
     *
     * @param IntegrationTester $I
     *
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2018-11-13
     */
    public function dbAdapterPdoPostgresqlInsertAsDict(IntegrationTester $I)
    {
        $I->wantToTest("Db\Adapter\Pdo\Postgresql - insertAsDict()");
        $I->skipTest("Need implementation");
    }
}
