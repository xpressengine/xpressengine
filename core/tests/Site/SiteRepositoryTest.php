<?php

/**
 * SiteHandlerTest
 *
 * PHP version 5
 *
 * @category  Test
 * @package   Xpressengine\Tests\Site
 * @author    XE Team (developers) <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      http://www.xpressengine.com
 */

namespace Xpressengine\Tests\Site;

use Illuminate\Cache\CacheManager;
use Mockery as m;
use Illuminate\Support\Collection;
use PHPUnit_Framework_TestCase;
use \Xpressengine\Routing\InstanceRoute;
use \Xpressengine\Routing\Exceptions\NotFoundInstanceRouteException;
use \Xpressengine\Routing\Exceptions\UnusableUrlException;
use \Xpressengine\Routing\Exceptions\UnusableInstanceIdException;
use \Xpressengine\Routing\InstanceRouteRepository;
use Xpressengine\Site\Site;
use Xpressengine\Site\SiteRepository;

/**
 * Class SiteHandlerTest
 *
 * @category Test
 * @package  Xpressengine\Tests\Site
 * @author   XE Team (developers) <developers@xpressengine.com>
 * @license  http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link     http://www.xpressengine.com
 */
class SiteRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    protected $table = 'site';

    /**
     * @var \Mockery\MockInterface
     */
    protected $conn;
    /**
     * @var \Mockery\MockInterface
     */
    protected $query;

    /**
     * tearDown
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * testFind
     *
     * @return void
     */
    public function testFind()
    {
        $repo = new SiteRepository($this->conn);
        $query = $this->query;

        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('first')->andReturn(
            [
                'host' => 'test.com',
                'siteKey' => 'test',
            ]
        );

        $site = $repo->find('test.com');

        $this->assertEquals($site->host, 'test.com');
        $this->assertEquals($site->siteKey, 'test');
    }

    /**
     * testFindException
     *
     * @return void
     */
    public function testFindException()
    {
        $this->setExpectedException('Xpressengine\Site\Exceptions\NotFoundSiteException');
        $repo = new SiteRepository($this->conn);
        $query = $this->query;

        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('first')->andReturn(null);

        $repo->find('test.com');

    }

    /**
     * testFindBySiteKey
     *
     * @return void
     */
    public function testFindBySiteKey()
    {
        $repo = new SiteRepository($this->conn);
        $query = $this->query;

        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('first')->andReturn(
            [
                'host' => 'test.com',
                'siteKey' => 'test',
            ]
        );

        $site = $repo->findBySiteKey('test');

        $this->assertEquals($site->host, 'test.com');
        $this->assertEquals($site->siteKey, 'test');
    }

    /**
     * testFindBySiteKeyException
     *
     * @return void
     */
    public function testFindBySiteKeyException()
    {
        $this->setExpectedException('Xpressengine\Site\Exceptions\NotFoundSiteException');
        $repo = new SiteRepository($this->conn);
        $query = $this->query;

        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('first')->andReturn(null);

        $repo->findBySiteKey('test');

    }

    /**
     * testInsert
     *
     * @return void
     */
    public function testInsert()
    {
        $repo = new SiteRepository($this->conn);

        $query = $this->query;

        $site = new Site(
            [
                'host' => 'test.com',
                'siteKey' => 'test',
            ]
        );

        $query->shouldReceive('insert')->andReturn(true);

        $result = $repo->insert($site);

        $this->assertEquals('test.com', $result->host);
        $this->assertEquals('test', $result->siteKey);

    }

    /**
     * testUpdate
     *
     * @return void
     */
    public function testUpdate()
    {
        $repo = new SiteRepository($this->conn);

        $query = $this->query;
        $query->shouldReceive('update')->andReturn(1);
        $query->shouldReceive('where')->andReturn($query);

        $query->shouldReceive('first')->andReturn(
            [
                'host' => 'test.com',
                'siteKey' => 'test',
            ]
        );

        /**
         * @var Site $site
         */
        $site = $repo->find('test.com');
        $site->host = 'test2.com';

        $updatedSite = $repo->update($site);

        $this->assertEquals('test2.com', $updatedSite->host);
        $this->assertEquals('test', $updatedSite->siteKey);

    }

    /**
     * testDeleteOneAliasRoute
     *
     * @return void
     */
    public function testDeleteOneAliasRoute()
    {
        $repo = new SiteRepository($this->conn);

        $query = $this->query;
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('delete')->andReturn(1);

        $site = new Site(
            [
                'host' => 'test.com',
                'siteKey' => 'test',
            ]
        );

        $affected = $repo->delete($site);

        $this->assertEquals(1, $affected);
    }

    /**
     * countByUrl
     *
     * @return void
     */
    public function testCountByUrl()
    {
        $repo = new SiteRepository($this->conn);

        $query = $this->query;
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('count')->andReturn(1);

        $affected = $repo->count('test.com');

        $this->assertEquals(1, $affected);
    }

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp()
    {
        $connMock = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $queryMock = m::mock('Illuminate\Database\Query\Builder');

        $this->conn = $connMock;
        $this->query = $queryMock;

        $this->conn->shouldReceive('table')->andReturn($queryMock);

        parent::setUp();
    }
}
