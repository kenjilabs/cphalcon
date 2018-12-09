<?php

/*
 +------------------------------------------------------------------------+
 | Phalcon Framework                                                      |
 +------------------------------------------------------------------------+
 | Copyright (c) 2011-present Phalcon Team (https://phalconphp.com)       |
 +------------------------------------------------------------------------+
 | This source file is subject to the New BSD License that is bundled     |
 | with this package in the file LICENSE.txt.                             |
 |                                                                        |
 | If you did not receive a copy of the license and are unable to         |
 | obtain it through the world-wide-web, please send an email             |
 | to license@phalconphp.com so we can send you a copy immediately.       |
 +------------------------------------------------------------------------+
 */

namespace Phalcon\Test\Integration\Mvc;

use IntegrationTester;
use Phalcon\Events\Manager;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Tag;
use Phalcon\Test\Fixtures\Mvc\View\AfterRenderListener;

/**
 * Phalcon\Test\Integration\Mvc\View\ViewCest
 *
 * Test work Compiler with files
 *
 * @package Phalcon\Test\Integration\Mvc
 */
class ViewCest
{
    /**
     * Tests the View::getActiveRenderPath
     *
     * @test
     * @issue  https://github.com/phalcon/cphalcon/issues/12139
     * @author Phalcon Team <team@phalconphp.com>
     * @since  2014-08-14
     */
    public function shouldGetActiveRenderPath(IntegrationTester $I)
    {
        $I->wantToTest('Gitting active path');

        $eventsManager = new Manager;
        $eventsManager->attach('view', new AfterRenderListener());

        $view = new View;
        $view->setViewsDir(dataFolder('views' . DIRECTORY_SEPARATOR));
        $view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        $view->setEventsManager($eventsManager);

        $expected = '';
        $actual   = $view->getActiveRenderPath();
        $I->assertEquals($expected, $actual);

        $view->start();
        $view->render('activerender', 'index');
        $view->finish();

        $view->getContent();

        $I->assertEquals(
            dataFolder('views' . DIRECTORY_SEPARATOR . 'activerender' . DIRECTORY_SEPARATOR . 'index.phtml'),
            $view->getActiveRenderPath()
        );

        $view->setViewsDir([
            dataFolder('views' . DIRECTORY_SEPARATOR),
            dataFolder('views2' . DIRECTORY_SEPARATOR),
        ]);

        $I->assertEquals(
            [dataFolder('views' . DIRECTORY_SEPARATOR . 'activerender' . DIRECTORY_SEPARATOR . 'index.phtml')],
            $view->getActiveRenderPath()
        );
    }

    /**
     * Tests the View::getCurrentRenderLevel
     *
     * @test
     * @issue  https://github.com/phalcon/cphalcon/issues/907
     * @author Volodymyr Kolesnykov <volodymyr@wildwolf.name>
     * @since  2013-10-03
     */
    public function shouldGetCurrentRenderLevel(IntegrationTester $I)
    {
        $I->wantToTest('Getting current path');
        $I->skipTest('TODO - Check me');
        $listener      = new AfterRenderListener;
        $eventsManager = new Manager;
        $eventsManager->attach('view', $listener);

        $view = new View;
        $view->setViewsDir(dataFolder('fixtures/views' . DIRECTORY_SEPARATOR));
        $view->setEventsManager($eventsManager);

        $view->start();
        $view->render('currentrender', 'other');
        $view->finish();
        $I->assertEquals("<html>lolhere</html>\n", $view->getContent());
        $I->assertEquals('1,3,5', $listener->getLevels());

        $listener->reset();
        $view->setTemplateAfter('test');
        $view->start();
        $view->render('currentrender', 'other');
        $view->finish();
        $I->assertEquals("<html>zuplolhere</html>\n", $view->getContent());
        $I->assertEquals('1,3,4,5', $listener->getLevels());

        $listener->reset();
        $view->cleanTemplateAfter();
        $view->setRenderLevel(View::LEVEL_MAIN_LAYOUT);
        $view->start();
        $view->render('currentrender', 'other');
        $view->finish();
        $I->assertEquals("<html>lolhere</html>\n", $view->getContent());
        $I->assertEquals('1,3,5', $listener->getLevels());

        $listener->reset();
        $view->setRenderLevel(View::LEVEL_LAYOUT);
        $view->start();
        $view->render('currentrender', 'other');
        $view->finish();
        $I->assertEquals('lolhere', $view->getContent());
        $I->assertEquals('1,3', $listener->getLevels());

        $listener->reset();
        $view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        $view->start();
        $view->render('currentrender', 'other');
        $view->finish();
        $I->assertEquals('here', $view->getContent());
        $I->assertEquals('1', $listener->getLevels());

        $listener->reset();
    }
}
