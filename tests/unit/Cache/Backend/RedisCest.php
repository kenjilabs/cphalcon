<?php

namespace Phalcon\Test\Unit\Cache\Backend;

use Phalcon\Cache\Backend\Redis;
use Phalcon\Cache\Exception;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Cache\Frontend\Output;
use UnitTester;
use function array_merge;

/**
 * \Phalcon\Test\Unit\Cache\Backend\RedisCest
 * Tests the \Phalcon\Cache\Backend\Redis component
 *
 * @copyright (c) 2011-2017 Phalcon Team
 * @link          http://www.phalconphp.com
 * @author        Andres Gutierrez <andres@phalconphp.com>
 * @author        Phalcon Team <team@phalconphp.com>
 * @package       Phalcon\Test\Unit\Cache\Backend
 *
 * The contents of this file are subject to the New BSD License that is
 * bundled with this package in the file LICENSE.txt
 *
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world-wide-web, please send an email to license@phalconphp.com
 * so that we can send you a copy immediately.
 */
class RedisCest
{
    public function _before(UnitTester $I)
    {
        $I->checkExtensionIsLoaded('redis');
    }

    public function exists(UnitTester $I)
    {
        $I->wantTo('Check if cache exists in cache by using Redis as cache backend');
        $I->skipTest('TODO: Find out why the module cannot connect with the port');
        $key   = '_PHCR' . 'data-exists';
        $data  = [uniqid(), gethostname(), microtime(), get_include_path(), time()];
        $cache = $this->getClient(20, ['statsKey' => '_PHCR']);

        $I->haveInRedis('string', $key, serialize($data));

        $I->assertTrue($cache->exists('data-exists'));
        $I->assertFalse($cache->exists('non-existent-key'));
    }

    /**
     * @param int   $lifetime
     * @param array $options
     *
     * @return Redis
     */
    private function getClient(int $lifetime = 20, array $options = []): Redis
    {
        $config = [
            'host'  => env('DATA_REDIS_HOST'),
            'port'  => env('DATA_REDIS_PORT'),
            'index' => env('DATA_REDIS_NAME'),
        ];

        $config = array_merge($config, $options);

        return new Redis(new Data(['lifetime' => $lifetime]), $config);
    }

    public function existsWithoutStatsKey(UnitTester $I)
    {
        $I->wantTo('Check if cache exists in cache by using Redis as cache backend');
        $I->skipTest('TODO: Find out why the module cannot connect with the port');

        $key   = 'data-exists';
        $data  = [uniqid(), gethostname(), microtime(), get_include_path(), time()];
        $cache = $this->getClient();

        $I->dontSeeInRedis($key);
        $cache->save($key, serialize($data));

        $I->assertTrue($cache->exists('data-exists'));
        $I->assertFalse($cache->exists('_PHCR'));
    }

    /**
     * @issue https://github.com/phalcon/cphalcon/issues/12434
     * @param UnitTester $I
     */
    public function existsEmpty(UnitTester $I)
    {
        $I->wantTo('Check if cache exists for empty value in cache by using Redis as cache backend');
        $I->skipTest('TODO: Find out why the module cannot connect with the port');

        $key   = '_PHCR' . 'data-empty-exists';
        $cache = $this->getClient(20, ['statsKey' => '_PHCR']);

        $I->haveInRedis('string', $key, '');

        $I->assertTrue($cache->exists('data-empty-exists'));
        $I->assertFalse($cache->exists('non-existent-key'));
    }

    public function get(UnitTester $I)
    {
        $I->wantTo('Get data by using Redis as cache backend');
        $I->skipTest('TODO: Find out why the module cannot connect with the port');

        $key   = '_PHCR' . 'data-get';
        $data  = [uniqid(), gethostname(), microtime(), get_include_path(), time()];
        $cache = $this->getClient(20, ['statsKey' => '_PHCR']);

        $I->haveInRedis('string', $key, serialize($data));
        $I->assertEquals($data, $cache->get('data-get'));

        $I->assertNull($cache->get($key));

        $data = 'sure, nothing interesting';

        $I->haveInRedis('string', $key, serialize($data));
        $I->assertEquals($data, $cache->get('data-get'));

        $I->assertNull($cache->get($key));
    }

    /**
     * @issue https://github.com/phalcon/cphalcon/issues/12437
     * @param UnitTester $I
     */
    public function getEmpty(UnitTester $I)
    {
        $I->wantTo('Get empty value by using Redis as cache backend');
        $I->skipTest('TODO: Find out why the module cannot connect with the port');

        $key   = '_PHCR' . 'data-empty-get';
        $cache = $this->getClient(20, ['statsKey' => '_PHCR']);

        $I->haveInRedis('string', $key, '');
        $I->assertSame('', $cache->get('data-empty-get'));
    }

    public function save(UnitTester $I)
    {
        $I->wantTo('Save data by using Redis as cache backend');
        $I->skipTest('TODO: Find out why the module cannot connect with the port');

        $key   = '_PHCR' . 'data-save';
        $data  = [uniqid(), gethostname(), microtime(), get_include_path(), time()];
        $cache = $this->getClient(20, ['statsKey' => '_PHCR']);

        $I->dontSeeInRedis($key);
        $cache->save('data-save', $data);

        $I->seeInRedis($key, serialize($data));

        $data = 'sure, nothing interesting';

        $I->dontSeeInRedis($key, serialize($data));

        $cache->save('data-save', $data);
        $I->seeInRedis($key, serialize($data));
    }

    /**
     * @issue https://github.com/phalcon/cphalcon/issues/12327
     * @param UnitTester $I
     */
    public function saveNonExpiring(UnitTester $I)
    {
        $I->wantTo('Save data termlessly by using Redis as cache backend');
        $I->skipTest('TODO: Find out why the module cannot connect with the port');

        $key   = '_PHCR' . 'data-save-2';
        $data  = 1000;
        $cache = $this->getClient(200);

        $I->dontSeeInRedis($key);

        $cache->save('data-save-2', $data, -1);

        sleep(2);
        $I->seeInRedis($key);

        $cache->save('data-save-2', $data, 0);

        sleep(2);
        $I->seeInRedis($key);

        $cache->save('data-save-2', $data, 1);

        sleep(2);
        $I->dontSeeInRedis($key);
    }

    public function delete(UnitTester $I)
    {
        $I->wantTo(/** @lang text */
            'Delete from cache by using Redis as cache backend'
        );
        $I->skipTest('TODO: Find out why the module cannot connect with the port');
        $cache = $this->getClient(20, ['statsKey' => '_PHCR']);

        $I->assertFalse($cache->delete('non-existent-keys'));

        $I->haveInRedis('string', '_PHCR' . 'some-key-to-delete', 1);

        $I->assertTrue($cache->delete('some-key-to-delete'));
        $I->dontSeeInRedis('_PHCR' . 'some-key-to-delete');
    }

    public function flush(UnitTester $I)
    {
        $I->wantTo('Flush cache by using Redis as cache backend');
        $I->skipTest('TODO: Find out why the module cannot connect with the port');
        $cache = $this->getClient(20, ['statsKey' => '_PHCR']);

        $key1 = '_PHCR' . 'data-flush-1';
        $key2 = '_PHCR' . 'data-flush-2';

        $I->haveInRedis('string', $key1, 1);
        $I->haveInRedis('string', $key2, 2);

        $I->haveInRedis('set', '_PHCR', 'data-flush-1');
        $I->haveInRedis('set', '_PHCR', 'data-flush-2');

        $cache->save('data-flush-1', 1);
        $cache->save('data-flush-2', 2);

        $I->assertTrue($cache->flush());

        $I->dontSeeInRedis($key1);
        $I->dontSeeInRedis($key2);
    }

    public function queryKeys(UnitTester $I)
    {
        $I->wantTo('Get cache keys by using Redis as cache backend');
        $I->skipTest('TODO: Find out why the module cannot connect with the port');
        $cache = $this->getClient(20, ['statsKey' => '_PHCR']);

        $I->haveInRedis('string', '_PHCR' . 'a', 1);
        $I->haveInRedis('string', '_PHCR' . 'b', 2);
        $I->haveInRedis('string', '_PHCR' . 'c', 3);

        $I->haveInRedis('set', '_PHCR', 'a');
        $I->haveInRedis('set', '_PHCR', 'b');
        $I->haveInRedis('set', '_PHCR', 'c');

        $keys = $cache->queryKeys();
        sort($keys);

        $I->assertEquals(['a', 'b', 'c'], $keys);
    }

    public function queryKeysWithoutStatsKey(UnitTester $I)
    {
        $I->wantTo('Catch exception during the attempt getting cache keys by using Redis as cache backend without statsKey');
        $I->skipTest('TODO: Find out why the module cannot connect with the port');
        $cache = $this->getClient();

        $I->expectThrowable(
            new Exception("Cached keys need to be enabled to use this function (options['statsKey'] == '_PHCR')!"),
            function () use ($cache) {
                $cache->queryKeys();
            }
        );
    }

    public function output(UnitTester $I)
    {
        $I->wantTo('Cache output fragments by using Redis as cache backend');
        $I->skipTest('TODO: Find out why the module cannot connect with the port');

        $time  = date('H:i:s');
        $cache = $this->getClient(2);

        ob_start();

        // First time cache
        $content = $cache->start('test-output');
        $I->assertNull($content);

        echo $time;
        $cache->save(null, null, null, true);

        $obContent = ob_get_contents();
        ob_end_clean();

        $I->assertEquals($time, $obContent);
        $I->seeInRedis('_PHCR' . 'test-output', $time);

        // Expect same cache
        $content = $cache->start('test-output');
        $I->assertNotNull($content);

        $I->assertEquals($time, $obContent);
        $I->seeInRedis('_PHCR' . 'test-output', $time);

        sleep(2);
        $content = $cache->start('test-output');

        $I->assertNull($content);
        $I->dontSeeInRedis('_PHCR' . 'test-output');
    }

    public function setTimeout(UnitTester $I)
    {
        $I->wantTo('Get data by using Redis as cache backend and set timeout');
        $I->skipTest('TODO: Find out why the module cannot connect with the port');
        $key   = '_PHCR' . 'data-get-timeout';
        $data  = [uniqid(), gethostname(), microtime(), get_include_path(), time()];
        $cache = $this->getClient(20, ['statsKey' => '_PHCR', 'timeout' => 1]);

        $I->haveInRedis('string', $key, serialize($data));
        $I->assertEquals($data, $cache->get('data-get-timeout'));

        $I->assertNull($cache->get($key));

        $data = 'sure, nothing interesting';

        $I->haveInRedis('string', $key, serialize($data));
        $I->assertEquals($data, $cache->get('data-get-timeout'));

        $I->assertNull($cache->get($key));
    }

    public function queryKeysWithStatsKeyAndPrefix(UnitTester $I)
    {
        $I->wantTo('Get cache data with prefix and statsKey configuration');
        $I->skipTest('TODO: Find out why the module cannot connect with the port');

        $cache = $this->getClient(20, ['statsKey' => '_PHCR', 'prefix' => 'phalcon-']);
        $cache->flush();
        $data = [uniqid(), gethostname(), microtime(), get_include_path(), time()];
        $cache->save('a', $data);
        $cache->save('b', $data);

        $keys = $cache->queryKeys();
        sort($keys);

        $I->assertEquals(['phalcon-a', 'phalcon-b'], $keys);
        $I->assertEquals($data, $cache->get('a'));
        $I->assertEquals($data, $cache->get('b'));
    }
}
