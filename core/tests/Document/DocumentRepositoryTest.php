<?php
/**
 *
 */
namespace Xpressengine\Tests\Document;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Xpressengine\Document\Repositories\DocumentRepository;

/**
 * Class DocumentRepositoryTest
 * @package Xpressengine\Tests\Document
 */
class DocumentRepositoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var m\MockInterface|\Xpressengine\Database\VirtualConnectionInterface
     */
    protected $conn;

    /**
     * @var m\MockInterface|\Xpressengine\Database\DynamicQuery
     */
    protected $query;

    /**
     * @var m\MockInterface|\Xpressengine\Database\ProxyManager
     */
    protected $proxyManager;
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

        $this->conn = $conn;
        $this->query = $query;
        $this->proxyManager = $proxyManager;
    }

    /**
     * @return m\MockInterface|\Xpressengine\Document\DocumentEntity
     */
    private function getDocumentEntity()
    {
        return m::mock('Xpressengine\Document\DocumentEntity');
    }

    /**
     * get config entity
     *
     * @return m\MockInterface|\Xpressengine\Config\ConfigEntity
     */
    private function getConfigEntity()
    {
        return m::mock('Xpressengine\Config\ConfigEntity');
    }

    /**
     * @param array $items items
     *
     * @return m\MockInterface|\Illuminate\Pagination\LengthAwarePaginator
     */
    private function getPaginator(array $items)
    {
        return m::mock('Illuminate\Pagination\LengthAwarePaginator');
    }

    /**
     * test get property
     *
     * @return void
     */
    public function testGetProperty()
    {
        $conn = $this->conn;

        $repo = new DocumentRepository($conn);

        $this->assertInstanceOf('Xpressengine\Database\VirtualConnectionInterface', $repo->connection());
        $this->assertEquals('documents', $repo->table());
    }

    /**
     * test insert
     *
     * @return void
     */
    public function testInsert()
    {
        $conn = $this->conn;

        $repo = new DocumentRepository($conn);

        $doc = $this->getDocumentEntity();
        $doc->shouldReceive('getAttributes')->andReturn([]);

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);
        $config->shouldReceive('get')->with('instanceId')->andReturn('instanceId');

        $this->query->shouldReceive('insert');

        $result = $repo->insert($doc, $config);
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);
    }

    /**
     * test update
     *
     * @return void
     */
    public function testUpdate()
    {
        $conn = $this->conn;

        $repo = new DocumentRepository($conn);

        $doc = $this->getDocumentEntity();
        $doc->shouldReceive('getAttributes')->andReturn([]);

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);
        $config->shouldReceive('get')->with('instanceId')->andReturn('instanceId');

        $this->query->shouldReceive('update');
        $this->query->shouldReceive('where')->andReturn($this->query);

        $result = $repo->update($doc, $config);
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);
    }

    /**
     * test delete
     *
     * @return void
     */
    public function testDelete()
    {
        $conn = $this->conn;

        $repo = new DocumentRepository($conn);

        $doc = $this->getDocumentEntity();

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);
        $config->shouldReceive('get')->with('instanceId')->andReturn('instanceId');

        $this->query->shouldReceive('delete')->andReturn(1);
        $this->query->shouldReceive('where')->andReturn($this->query);

        $result = $repo->delete($doc, $config);
        $this->assertEquals(1, $result);

        $result = $repo->deleteByInstanceId('instanceId');
        $this->assertEquals(1, $result);
    }

    /**
     * test build where query
     *
     * @return void
     */
    public function testWheres()
    {
        $conn = $this->conn;

        $repo = new DocumentRepository($conn);

        $query = $this->query;
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('whereBetween')->andReturn($query);
        $query->shouldReceive('whereIn')->andReturn($query);
        $query->shouldReceive('whereNested')->andReturn($query);
        $query->shouldReceive('getQuery')->andReturn(m::mock('Illuminate\Database\Query\Builder'));
        $query->shouldReceive('getProxyManager')->andReturn($this->proxyManager);

        $wheres = [
            'id' => 'id',
            'documentId' => 'documentId',
            'parentId' => 'parentId',
            'instanceId' => 'instanceId',
            'instanceIds' => 'instanceIds',
            'userId' => 'userId',
            'writer' => 'writer',
            'likeUserName' => 'likeUserName',
            'title_content' => 'title_content',
            'content' => 'content',
            'title' => 'title',
            'createdAtMore' => 'createdAtMore',
            'createdAtLess' => 'createdAtLess',
            'createdAtBetween' => ['createdAtBetween1', 'createdAtBetween2'],
            'status' => 'status',
            'approved' => 'approved',
            'published' => 'published',
            'display' => 'display',
        ];

        $result = $repo->wheres($query, $wheres);
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $result);
    }


    /**
     * test build order query
     *
     * @return void
     */
    public function testOrders()
    {
        $conn = $this->conn;

        $repo = new DocumentRepository($conn);

        $query = $this->query;
        $query->shouldReceive('orderBy')->andReturn($query);
        $query->shouldReceive('whereBetween')->andReturn($query);
        $query->shouldReceive('whereIn')->andReturn($query);
        $query->shouldReceive('whereNested')->andReturn($query);
        $query->shouldReceive('getQuery')->andReturn(m::mock('Illuminate\Database\Query\Builder'));
        $query->shouldReceive('getProxyManager')->andReturn($this->proxyManager);

        $orders = [];
        $result = $repo->orders($query, $orders);
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $result);

        $orders = [
            'createdAt' => 'createdAt',
            'updatedAt' => 'updatedAt',
            'readCount' => 'readCount',
            'assentCount' => 'assentCount',
            'dissentCount' => 'dissentCount',
            'head' => 'head',
            'reply' => 'reply',
        ];

        $result = $repo->orders($query, $orders);
        $this->assertInstanceOf('Xpressengine\Database\DynamicQuery', $result);
    }

    /**
     * test find
     *
     * @return void
     */
    public function testFind()
    {
        $conn = $this->conn;

        $repo = new DocumentRepository($conn);

        $id = 'documentId';

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);
        $config->shouldReceive('get')->with('instanceId')->andReturn('instanceId');

        $query = $this->query;
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('first')->andReturn(['id'=>$id]);

        $result = $repo->find($id, $config);
        $this->assertEquals($id, $result['id']);
    }

    /**
     * test find by id
     *
     * @return void
     */
    public function testFindById()
    {
        $conn = $this->conn;

        $repo = new DocumentRepository($conn);

        $id = 'documentId';

        $query = $this->query;
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('first')->andReturn(['id'=>$id]);

        $result = $repo->findById($id);
        $this->assertEquals($id, $result['id']);
    }


    /**
     * test fetch by ids
     *
     * @return void
     */
    public function testFetchByIds()
    {
        $conn = $this->conn;

        $repo = new DocumentRepository($conn);

        $id = 'documentId';

        $query = $this->query;
        $query->shouldReceive('whereIn')->andReturn($query);
        $query->shouldReceive('get')->andReturn([['id'=>$id]]);

        $result = $repo->fetchByIds([$id]);
        $this->assertEquals($id, $result[0]['id']);
    }

    /**
     * test fetch documents
     *
     * @return void
     */
    public function testFetch()
    {
        $conn = $this->conn;

        $repo = m::mock('Xpressengine\Document\Repositories\DocumentRepository', [$conn])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();


        $wheres = [];
        $orders = [];

        $config = null;

        $query = $this->query;
        $query->shouldReceive('take')->andReturn($query);
        $query->shouldReceive('get')->andReturn([]);

        $repo->shouldReceive('wheres')->andReturn($query);
        $repo->shouldReceive('orders')->andReturn($query);

        // without config
        $result = $repo->fetch($wheres, $orders, $config, 5);
        $this->assertEquals(0, count($result));

        // with config
        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);
        $config->shouldReceive('get')->with('instanceId')->andReturn('instanceId');

        $result = $repo->fetch(null, null, $config, 5);
        $this->assertEquals(0, count($result));
    }

    /**
     * test paginate documents
     *
     * @return void
     */
    public function testPaginate()
    {
        $conn = $this->conn;

        $repo = m::mock('Xpressengine\Document\Repositories\DocumentRepository', [$conn])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();


        $wheres = [];
        $orders = [];

        $config = null;

        $query = $this->query;
        $query->shouldReceive('paginate')->andReturn($this->getPaginator([]));

        $repo->shouldReceive('wheres')->andReturn($query);
        $repo->shouldReceive('orders')->andReturn($query);

        // without config
        $result = $repo->paginate($wheres, $orders, $config);
        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $result);

        // with config
        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);
        $config->shouldReceive('get')->with('instanceId')->andReturn('instanceId');

        $result = $repo->paginate(null, null, $config, 5);
        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $result);
    }

    /**
     * test count
     *
     * @return void
     */
    public function testCount()
    {
        $conn = $this->conn;

        $repo = m::mock('Xpressengine\Document\Repositories\DocumentRepository', [$conn])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();


        $wheres = [];
        $orders = [];

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);
        $config->shouldReceive('get')->with('instanceId')->andReturn('instanceId');

        $query = $this->query;
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('count')->andReturn(0);

        $repo->shouldReceive('wheres')->andReturn($query);

        $result = $repo->count($wheres, $config);
        $this->assertEquals(0, $result);

        $result = $repo->countByInstanceId('instanceId');
        $this->assertEquals(0, $result);

    }

    /**
     * test get last child reply
     *
     * @return void
     */
    public function testGetLastChildReply()
    {
        $conn = $this->conn;

        $repo = new DocumentRepository($conn);

        $code = 'aaa';

        $doc = $this->getDocumentEntity();

        $query = $this->query;
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('max')->andReturn($code);

        $result = $repo->getLastChildReply($doc, 3);
        $this->assertEquals($code, $result);
    }

    /**
     * test get replies
     *
     * @return void
     */
    public function testGetReplies()
    {
        $conn = $this->conn;

        $repo = new DocumentRepository($conn);

        $doc = $this->getDocumentEntity();
        $doc->reply = 'aaa';

        $query = $this->query;
        $query->shouldReceive('where')->andReturn($query);
        $query->shouldReceive('get')->andReturn([]);

        $result = $repo->getReplies($doc);
        $this->assertEquals(0, count($result));
    }
}
