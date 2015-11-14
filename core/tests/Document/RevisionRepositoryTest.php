<?php
/**
 *
 */
namespace Xpressengine\Tests\Document;

use Mockery as M;
use PHPUnit_Framework_TestCase;
use Xpressengine\Document\Repositories\RevisionRepository;

/**
 * Class DocumentRepositoryTest
 * @package Xpressengine\Tests\Document
 */
class RevisionRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var M\MockInterface|\Xpressengine\Database\VirtualConnectionInterface
     */
    protected $conn;

    /**
     * @var M\MockInterface|\Xpressengine\Database\DynamicQuery
     */
    protected $query;

    /**
     * @var M\MockInterface|\Xpressengine\Database\ProxyManager
     */
    protected $proxyManager;

    /**
     * @var M\MockInterface|\Xpressengine\DynamicField\RevisionManager
     */
    protected $revisionManager;

    /**
     * @var M\MockInterface|\Xpressengine\Keygen\Keygen
     */
    protected $keygen;

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
        $proxyManager = m::mock('Xpressengine\Database\ProxyManager');
        $proxyManager->shouldReceive('wheres');
        $proxyManager->shouldReceive('orders');

        $query = m::mock('Xpressengine\Database\DynamicQuery');

        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $conn->shouldReceive('table')->andReturn($query);
        $conn->shouldReceive('dynamic')->andReturn($query);

        $revisionManager = m::mock('Xpressengine\DynamicField\RevisionManager');
        $keygen = m::mock('Xpressengine\Keygen\Keygen');

        $this->conn = $conn;
        $this->query = $query;
        $this->proxyManager = $proxyManager;
        $this->revisionManager = $revisionManager;
        $this->keygen = $keygen;
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
     * @param array $items items
     *
     * @return M\MockInterface|\Illuminate\Pagination\LengthAwarePaginator
     */
    private function getPaginator(array $items)
    {
        return m::mock('Illuminate\Pagination\LengthAwarePaginator');
    }

    /**
     * test set except columns
     *
     * @return void
     */
    public function testSetExceptColumns()
    {
        $conn = $this->conn;
        $revisionManager = $this->revisionManager;
        $keygen = $this->keygen;

        $repo = new RevisionRepository($conn, $revisionManager, $keygen);

        $exceptColumns = [];

        $repo->setExceptColumns($exceptColumns);

        $reflection = new \ReflectionClass(get_class($repo));
        $property = $reflection->getProperty('exceptColumns');
        $property->setAccessible(true);
        $result = $property->getValue($repo);

        $this->assertEquals($exceptColumns, $result);

        $repo->addExceptColumn('column1');

        $result = $property->getValue($repo);
        $this->assertEquals(['column1'], $result);
    }

    /**
     * test is changed
     *
     * @return void
     */
    public function testIsChanged()
    {
        $conn = $this->conn;
        $revisionManager = $this->revisionManager;
        $keygen = $this->keygen;

        $repo = new RevisionRepository($conn, $revisionManager, $keygen);

        $doc = $this->getDocumentEntity();
        $doc->shouldReceive('diff')->once()->andReturn([]);
        $this->assertFalse($repo->isChanged($doc));

        $doc->shouldReceive('diff')->once()->andReturn(['changedColumne' => 'changedValue']);
        $this->assertTrue($repo->isChanged($doc));
    }

    /**
     * test get next revision no
     *
     * @return void
     */
    public function testNextNo()
    {
        $conn = $this->conn;
        $revisionManager = $this->revisionManager;
        $keygen = $this->keygen;

        $repo = new RevisionRepository($conn, $revisionManager, $keygen);

        $query = $this->query;
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('max')->andReturn(null);

        $result = $repo->nextNo('documentId');
        $this->assertEquals(1, $result);
    }


    /**
     * test insert
     *
     * @return void
     */
    public function testInsert()
    {
        $conn = $this->conn;
        $revisionManager = $this->revisionManager;
        $keygen = $this->keygen;

        $repo = m::mock('Xpressengine\Document\Repositories\RevisionRepository', [
            $conn, $revisionManager, $keygen
        ])->shouldAllowMockingProtectedMethods()->makePartial();

        $doc = $this->getDocumentEntity();
        $doc->shouldReceive('getAttributes')->andReturn([]);
        $doc->id = 'documentId';

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('group')->andReturn('document-instanceId');

        $repo->shouldReceive('nextNo')->andReturn(1);

        $keygen->shouldReceive('generate')->andReturn('revisionId');

        $revisionManager->shouldReceive('getHandler')->andReturn(
            $dynamicFieldHandler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler')
        );
        $dynamicFieldHandler->shouldReceive('getConfigHandler')->andReturn(
            $dfConfigHandler = m::mock('Xpressengine\DynamicField\ConfigHandler')
        );
        $dfConfigHandler->shouldReceive('gets')->andReturn([]);

        $this->query->shouldReceive('insert');
        $revisionManager->shouldReceive('add');

        $result = $repo->insert($doc, $config);
        $this->assertEquals($doc, $result);
    }

    /**
     * test find
     *
     * @return void
     */
    public function testFind()
    {
        $conn = $this->conn;
        $revisionManager = $this->revisionManager;
        $keygen = $this->keygen;

        $repo = new RevisionRepository($conn, $revisionManager, $keygen);

        $revisionId = 'revisoinId';

        $query = $this->query;
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('first')->andReturn(['revisionId' => $revisionId]);

        $result =$repo->find($revisionId);
        $this->assertEquals($revisionId, $result['revisionId']);
    }

    /**
     * test fetch by id
     *
     * @return void
     */
    public function testFetchById()
    {
        $conn = $this->conn;
        $revisionManager = $this->revisionManager;
        $keygen = $this->keygen;

        $repo = m::mock('Xpressengine\Document\Repositories\RevisionRepository', [
            $conn, $revisionManager, $keygen
        ])->shouldAllowMockingProtectedMethods()->makePartial();

        $id = 'documentId';
        $revisionId = 'revisionId';

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('group')->andReturn('document-instanceId');

        $query = $this->query;
        $query->shouldReceive('getQuery')->andReturn(m::mock('Illuminate\Database\Query\Builder'));
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('orderBy')->andReturn($query);
        $query->shouldReceive('get')->andReturn([
            ['id' => $id, 'revisionId' => $revisionId]
        ]);

        $revisionManager->shouldReceive('join')->andReturn($query);
        $revisionManager->shouldReceive('getHandler')->andReturn(
            $dynamicFieldHandler = m::mock('Xpressengine\DynamicField\DynamicFieldHandler')
        );
        $dynamicFieldHandler->shouldReceive('getConfigHandler')->andReturn(
            $dfConfigHandler = m::mock('Xpressengine\DynamicField\ConfigHandler')
        );
        $dfConfigHandler->shouldReceive('gets')->andReturn([]);

        $result = $repo->fetchById($id, $config);

        $this->assertEquals($id, $result[0]['id']);
    }

    /**
     * test delete
     *
     * @return void
     */
    public function testDelete()
    {
        $conn = $this->conn;
        $revisionManager = $this->revisionManager;
        $keygen = $this->keygen;

        $repo = new RevisionRepository($conn, $revisionManager, $keygen);

        $instanceId = 'instanceId';
        $id = 'documentId';
        $revisionId = 'revisionId';

        $doc = $this->getDocumentEntity();
        $doc->revisionId = $revisionId;
        $doc->id = $id;
        $doc->instanceId = $instanceId;

        $query = $this->query;
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('delete')->andReturn(1);

        $result = $repo->deleteByInstanceId($instanceId);
        $this->assertEquals(1, $result);

        $repo->delete($doc);

        $repo->deleteByDocumentId($id);
    }
}
