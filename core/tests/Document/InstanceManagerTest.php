<?php
/**
 *
 */
namespace Xpressengine\Tests\Document;

use Mockery as M;
use PHPUnit_Framework_TestCase;
use Xpressengine\Document\InstanceManager;

/**
 * Class DocumentHandler
 * @package Xpressengine\Tests\Document
 */
class InstanceManagerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var M\MockInterface|\Xpressengine\Document\RepositoryInterface
     */
    protected $repo;

    /**
     * @var M\MockInterface|\Xpressengine\Document\ConfigHandler
     */
    protected $configHandler;

    /**
     * tear down
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * set up
     *
     * @return void
     */
    public function setUp()
    {
        $repo = m::mock('Xpressengine\Document\RepositoryInterface');
        $configHandler = m::mock('Xpressengine\Document\ConfigHandler');

        $this->repo = $repo;
        $this->configHandler = $configHandler;

        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $conn->shouldReceive('beginTransaction');
        $conn->shouldReceive('commit');

        $this->repo->shouldReceive('connection')->andReturn($conn);
    }

    /**
     * @return M\MockInterface|\Xpressengine\Document\DocumentEntity
     */
    private function getDocumentEntity()
    {
        return m::mock('Xpressengine\Document\DocumentEntity');
    }

    /**
     * get config entity
     *
     * @return M\MockInterface|\Xpressengine\Config\ConfigEntity
     */
    private function getConfigEntity()
    {
        return m::mock('Xpressengine\Config\ConfigEntity');
    }

    /**
     * test add instance
     *
     * @return void
     */
    public function testAdd()
    {
        $repo = $this->repo;
        $configHandler = $this->configHandler;

        $manager = new InstanceManager($repo, $configHandler);

        $config = $this->getConfigEntity();
        $configHandler->shouldReceive('add');
        $repo->shouldReceive('createDivisionTable');

        $manager->add($config);
    }

    /**
     * test put instance config
     *
     * @return void
     */
    public function testPut()
    {
        $repo = $this->repo;
        $configHandler = $this->configHandler;

        $manager = new InstanceManager($repo, $configHandler);

        $config = $this->getConfigEntity();
        $configHandler->shouldReceive('put');

        $manager->put($config);
    }

    /**
     * test remove instance
     *
     * @return void
     */
    public function testRemove()
    {
        $repo = $this->repo;
        $configHandler = $this->configHandler;

        $manager = new InstanceManager($repo, $configHandler);

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);
        $config->shouldReceive('set');
        $config->shouldReceive('get')->with('instanceId')->andReturn('instanceId');

        $repo->shouldReceive('dropDivisionTable');
        $repo->shouldReceive('fetch')->once()->andReturn([
            ['id' => 'id1'], ['id' => 'id2']
        ]);
        $repo->shouldReceive('fetch')->once()->andReturn([]);
        $repo->shouldReceive('delete');

        $configHandler->shouldReceive('remove');

        $manager->remove($config);
    }
}
