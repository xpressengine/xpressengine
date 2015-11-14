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

use Mockery\MockInterface;
use PHPUnit_Framework_TestCase;
use Mockery as m;
use Xpressengine\Site\Site;
use Xpressengine\Site\SiteHandler;
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
class SiteHandlerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var MockInterface
     */
    protected $repo;
    /**
     * @var MockInterface
     */
    protected $config;
    /**
     * @var SiteHandler
     */
    protected $siteHandler;

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
     * testGetsBySite
     * set & get CurrentSite Test
     *
     * @return void
     */
    public function testCurrentSite()
    {
        $handler = $this->siteHandler;

        $testSite = new Site(['host' => 'test.com', 'siteKey' => 'test']);
        $handler->setCurrentSite($testSite);

        $site = $handler->getCurrentSite();

        $this->assertEquals('test.com', $site->host);
        $this->assertEquals('test', $site->siteKey);

        $this->assertEquals('test', $handler->getCurrentSiteKey());
    }

    /**
     * testDefaultSiteInfo
     *
     * @return void
     */
    public function testDefaultSiteInfo()
    {
        $config = $this->config;

        $config->shouldReceive('getVal')->with('site.test.defaultMenu')->andReturn('test_menu_id');
        $config->shouldReceive('getVal')->with('site.test.homeInstance')->andReturn('test_home_id');

        $handler = $this->siteHandler;

        $testSite = new Site(['host' => 'test.com', 'siteKey' => 'test']);

        $handler->setCurrentSite($testSite);

        $defaultMenu = $handler->getDefaultMenuEntityId();
        $homeInstanceId = $handler->getHomeInstanceId();

        $this->assertEquals('test_menu_id', $defaultMenu);
        $this->assertEquals('test_home_id', $homeInstanceId);
    }

    /**
     * testSetDefaultSiteInfo
     *
     * @return void
     */
    public function testSetDefaultSiteInfo()
    {
        $config = $this->config;

        $config->shouldReceive('setVal')->andReturn();

        $handler = $this->siteHandler;
        $testSite = new Site(['host' => 'test.com', 'siteKey' => 'test']);
        $handler->setCurrentSite($testSite);

        $handler->setDefaultMenuEntityId('test_menu_id');
        $handler->setHomeInstanceId('test_home_id');
    }

    /**
     * testGet
     *
     * @return void
     */
    public function testGet()
    {
        $testSite = new Site(['host' => 'test.com', 'siteKey' => 'test']);

        $repo = $this->repo;
        $repo->shouldReceive('find')->andReturn($testSite);

        $handler = $this->siteHandler;

        $site = $handler->get('test.com');

        $this->assertEquals('test.com', $site->host);
        $this->assertEquals('test', $site->siteKey);
    }

    /**
     * testGetBySiteKey
     *
     * @return void
     */
    public function testGetBySiteKey()
    {
        $testSite = new Site(['host' => 'test.com', 'siteKey' => 'test']);

        $repo = $this->repo;
        $repo->shouldReceive('findBySiteKey')->andReturn($testSite);

        $handler = $this->siteHandler;

        $site = $handler->getBySiteKey('test');

        $this->assertEquals('test.com', $site->host);
        $this->assertEquals('test', $site->siteKey);
    }

    /**
     * testAdd
     *
     * @return void
     */
    public function testAdd()
    {
        $repo = $this->repo;
        $repo->shouldReceive('insert')->andReturn();
        $repo->shouldReceive('count')->andReturn(0);

        $handler = $this->siteHandler;

        $site = $handler->add(['host' => 'test.com', 'siteKey' => 'test']);

        $this->assertEquals('test.com', $site->host);
        $this->assertEquals('test', $site->siteKey);
    }

    /**
     * testAddWithException
     *
     * @return void
     */
    public function testAddWithException()
    {
        $this->setExpectedException('Xpressengine\Site\Exceptions\CanNotUseDomainException');

        $repo = $this->repo;
        $repo->shouldReceive('insert')->andReturn();
        $repo->shouldReceive('count')->andReturn(1);

        $handler = $this->siteHandler;

        $handler->add(['host' => 'test.com', 'siteKey' => 'test']);


    }

    /**
     * testPut
     *
     * @return void
     */
    public function testPut()
    {
        $testSite = new Site(['host' => 'test.com', 'siteKey' => 'test']);

        $repo = $this->repo;
        $repo->shouldReceive('update')->andReturn();

        $handler = $this->siteHandler;

        $site = $handler->put($testSite);

        $this->assertEquals('test.com', $site->host);
        $this->assertEquals('test', $site->siteKey);
    }

    /**
     * testRemove
     *
     * @return void
     */
    public function testRemove()
    {
        $testSite = new Site(['host' => 'test.com', 'siteKey' => 'test']);

        $repo = $this->repo;
        $repo->shouldReceive('find')->andReturn($testSite);
        $repo->shouldReceive('delete')->andReturn();

        $handler = $this->siteHandler;

        $handler->remove('test.com');
    }

    /**
     * setUp
     *
     * @return void
     */
    protected function setUp()
    {
        /**
         * @var SiteRepository $repo
         */
        $repo = m::mock('Xpressengine\Site\SiteRepository');
        $config = m::mock('Xpressengine\Config\ConfigManager');

        $this->repo = $repo;
        $this->config = $config;

        $this->siteHandler = new SiteHandler($repo, $config);
        parent::setUp();
    }
}
