<?php
/**
 *
 */
namespace Xpressengine\Tests\Document;

use ArrayIterator;
use Mockery as m;
use PHPUnit_Framework_TestCase;
use Xpressengine\Document\DocumentHandler;

/**
 * Class DocumentHandler
 * @package Xpressengine\Tests\Document
 */
class DocumentHandlerTest extends PHPUnit_Framework_TestCase
{
    protected $conn;
    protected $auth;
    protected $member;
    protected $repo;
    protected $configHandler;
    protected $hasher;
    protected $instanceManager;
    protected $request;

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
        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $auth = m::mock('\Xpressengine\Member\GuardInterface');
        $member = m::mock('\Xpressengine\Member\Repositories\MemberRepositoryInterface');
        $repo = m::mock('Xpressengine\Document\RepositoryHandler');
        $configHandler = m::mock('Xpressengine\Document\ConfigHandler');
        $hasher = m::mock('Illuminate\Contracts\Hashing\Hasher');
        $instanceManager = m::mock('Xpressengine\Document\InstanceManager');
        $request = m::mock('\Illuminate\Http\Request');

        $this->conn = $conn;
        $this->auth = $auth;
        $this->member = $member;
        $this->repo = $repo;
        $this->configHandler = $configHandler;
        $this->hasher = $hasher;
        $this->instanceManager = $instanceManager;
        $this->request = $request;
    }


    /**
     * @return m\MockInterface|\Xpressengine\Document\DocumentEntity
     */
    private function getDocumentEntity()
    {
        return m::mock('Xpressengine\Document\DocumentEntity');
    }

    /**
     * get User instance
     *
     * @return m\MockInterface|\Xpressengine\Member\Entities\MemberEntityInterface
     */
    private function getUser()
    {
        $user = m::mock(
            'Xpressengine\Member\Entities\Database\MemberEntity',
            'Xpressengine\Member\Entities\MemberEntityInterface'
        );
        return $user;
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
        $paginator = m::mock('Illuminate\Pagination\LengthAwarePaginator');
        $paginator->shouldReceive('offsetSet');

        $arrayIterator = new ArrayIterator($items);

        $paginator->shouldReceive('getIterator')->andReturn($arrayIterator);

        return $paginator;
    }


    /**
     * test get property
     *
     * @return void
     */
    public function testGetProperty()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $this->assertInstanceOf('Xpressengine\Document\ConfigHandler', $handler->getConfigHandler());
        $this->assertInstanceOf('Xpressengine\Document\RepositoryInterface', $handler->getRepository());
        $this->assertInstanceOf('Xpressengine\Document\InstanceManager', $handler->getInstanceManager());
    }

    /**
     * test add document
     *
     * @return void
     */
    public function testAdd()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $user = $this->getUser();

        $user->shouldReceive('getId')->andReturn('userId');
        $user->shouldReceive('getDisplayName')->andReturn('userName');

        $doc = $this->getDocumentEntity();
        $doc->instanceId = 'instanceId';
        $doc->shouldReceive('setAuthor');
        $doc->shouldReceive('getAuthor')->andReturn($user);
        $doc->shouldReceive('setPureContent');

        $configHandler->shouldReceive('get')->andReturn(null);
        $configHandler->shouldReceive('getDefault')->andReturn($this->getConfigEntity());

        $request->shouldReceive('ip')->andReturn('127.0.0.1');

        $repo->shouldReceive('insert')->andReturn($doc);

        $result = $handler->add($doc);

        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);

        $doc->certifyKey = 'certifyKey';

        $result = $handler->add($doc);

        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);
    }

    /**
     * test without writer information
     *
     * @expectedException \Xpressengine\Document\Exceptions\RequiredValueException
     * @return void
     */
    public function testAddWithoutWriter()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $user = $this->getUser();

        $user->shouldReceive('getId')->andReturn('userId');
        $user->shouldReceive('getDisplayName')->andReturn('userName');

        $doc = $this->getDocumentEntity();
        $doc->instanceId = 'instanceId';
        $doc->userType = 'something';
        $doc->shouldReceive('setAuthor');
        $doc->shouldReceive('getAuthor')->andReturn($user);
        $doc->shouldReceive('setPureContent');

        $handler->add($doc);
    }

    /**
     * test without writer information
     *
     * @expectedException \Xpressengine\Document\Exceptions\RequiredValueException
     * @return void
     */
    public function testAddWithoutInstanceId()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $user = $this->getUser();

        $user->shouldReceive('getId')->andReturn('userId');
        $user->shouldReceive('getDisplayName')->andReturn('userName');

        $doc = $this->getDocumentEntity();
        $doc->shouldReceive('setAuthor');
        $doc->shouldReceive('getAuthor')->andReturn($user);
        $doc->shouldReceive('setPureContent');

        $handler->add($doc);
    }

    /**
     * test put
     *
     * @return void
     */
    public function testPut()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $user = $this->getUser();

        $user->shouldReceive('getId')->andReturn('userId');
        $user->shouldReceive('getDisplayName')->andReturn('userName');

        $doc = $this->getDocumentEntity();
        $doc->userId = 'userId';
        $doc->instanceId = 'instanceId';
        $doc->shouldReceive('diff')->andReturn(['certifyKey' => 'changedCertifyKey']);

        $doc->shouldReceive('setAuthor');
        $doc->shouldReceive('getAuthor')->andReturn($user);

        $doc->shouldReceive('setPureContent');
        $doc->shouldReceive('getOriginal')->andReturn(['instanceId' => $doc->instanceId]);

        $configHandler->shouldReceive('get')->andReturn(null);
        $configHandler->shouldReceive('getDefault')->andReturn($this->getConfigEntity());

        $repo->shouldReceive('update')->andReturn($doc);

        $result = $handler->put($doc);

        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);
    }

    /**
     * test put without user id
     *
     * @expectedException \Xpressengine\Document\Exceptions\RequiredValueException
     * @return void
     */
    public function testPutWithoutUserId()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $doc = $this->getDocumentEntity();
        $doc->instanceId = 'instanceId';
        $doc->shouldReceive('setPureContent');
        $doc->shouldReceive('getAuthor')->andReturn(null);

        $handler->put($doc);
    }

    /**
     * test put without user id
     *
     * @expectedException \Xpressengine\Document\Exceptions\RequiredValueException
     * @return void
     */
    public function testPutWithoutInstanceId()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $doc = $this->getDocumentEntity();
        $doc->userId = 'userId';
        $doc->shouldReceive('setPureContent');
        $doc->shouldReceive('getAuthor')->andReturn(null);

        $handler->put($doc);
    }

    /**
     * test remove
     *
     * @return void
     */
    public function testRemove()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $doc = $this->getDocumentEntity();
        $doc->instanceId = 'instanceId';

        $configHandler->shouldReceive('get')->andReturn(null);
        $configHandler->shouldReceive('getDefault')->andReturn($this->getConfigEntity());

        $repo->shouldReceive('delete')->andReturn(1);

        $result = $handler->remove($doc);
        $this->assertEquals(1, $result);
    }

    /**
     * test trash
     *
     * @return void
     */
    public function testTrash()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $doc = $this->getDocumentEntity();
        $doc->instanceId = 'instanceId';
        $doc->shouldReceive('trash');

        $configHandler->shouldReceive('get')->andReturn($this->getConfigEntity());

        $repo->shouldReceive('update')->andReturn($doc);

        $result = $handler->trash($doc);

        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);
    }

    /**
     * test trash without config entity
     *
     * @expectedException \Xpressengine\Document\Exceptions\ConfigNotExistsException
     * @return void
     */
    public function testTrashWithoutConfig()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $doc = $this->getDocumentEntity();
        $doc->shouldReceive('trash');

        $configHandler->shouldReceive('get')->andReturn(null);

        $handler->trash($doc);
    }

    /**
     * test restor
     *
     * @return void
     */
    public function testRestore()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $doc = $this->getDocumentEntity();
        $doc->instanceId = 'instanceId';
        $doc->shouldReceive('restore');

        $configHandler->shouldReceive('get')->andReturn($this->getConfigEntity());

        $repo->shouldReceive('update')->andReturn($doc);

        $result = $handler->restore($doc);

        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);
    }

    /**
     * test restore without config entity
     *
     * @expectedException \Xpressengine\Document\Exceptions\ConfigNotExistsException
     * @return void
     */
    public function testRestoreWithoutConfig()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $doc = $this->getDocumentEntity();
        $doc->shouldReceive('restore');

        $configHandler->shouldReceive('get')->andReturn(null);

        $handler->restore($doc);
    }

    /**
     * test get document
     *
     * @return void
     */
    public function testGet()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $instanceId = 'instanceId';
        $id = 'documentId';
        $userId = 'userId';

        $configHandler->shouldReceive('get')->andReturn($this->getConfigEntity());
        $repo->shouldReceive('find')->andReturn([
            'id' => $id,
            'instanceId' => $instanceId,
            'userId' => $userId,
        ]);

        $result = $handler->get($id, $instanceId);

        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);

        // check handler's cache
        $reflection = new \ReflectionClass(get_class($handler));
        $property = $reflection->getProperty('docs');
        $property->setAccessible(true);
        $docs = $property->getValue($handler);

        $this->assertEquals(1, count($docs));
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $docs[$id]);

        // get from cache
        $result = $handler->get($id, $instanceId);
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);

        // cache 가 변하지 않음
        $this->assertEquals(1, count($docs));
    }

    /**
     * test get without config entity
     *
     * @expectedException \Xpressengine\Document\Exceptions\ConfigNotExistsException
     * @return void
     */
    public function testGetWithoutConfig()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $instanceId = 'instanceId';
        $id = 'documentId';
        $userId = 'userId';

        $configHandler->shouldReceive('get')->andReturn(null);

        $handler->get($id, $instanceId);
    }

    /**
     * test get not exist document
     *
     * @expectedException \Xpressengine\Document\Exceptions\DocumentNotExistsException
     * @return void
     */
    public function testGetNotExistDocument()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $instanceId = 'instanceId';
        $id = 'documentId';
        $userId = 'userId';

        $configHandler->shouldReceive('get')->andReturn($this->getConfigEntity());
        $repo->shouldReceive('find')->andReturn(null);

        $handler->get($id, $instanceId);
    }

    /**
     * test get by document id
     * @return void
     */
    public function testGetById()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $instanceId = 'instanceId';
        $id = 'documentId';
        $userId = 'userId';

        $configHandler->shouldReceive('get')->andReturn($this->getConfigEntity());
        $repo->shouldReceive('findById')->andReturn([
            'id' => $id,
            'instanceId' => $instanceId,
            'userId' => $userId,
        ]);
        $repo->shouldReceive('find')->andReturn([
            'id' => $id,
            'instanceId' => $instanceId,
            'userId' => $userId,
        ]);

        $result = $handler->getById($id);

        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);

        // check handler's cache
        $reflection = new \ReflectionClass(get_class($handler));
        $property = $reflection->getProperty('docs');
        $property->setAccessible(true);
        $docs = $property->getValue($handler);

        $this->assertEquals(1, count($docs));
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $docs[$id]);

        // get from cache
        $result = $handler->getById($id);
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);
    }


    /**
     * test get documents by document ids
     *
     * @return void
     */
    public function testGetsByIds()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $ids = ['id1', 'id2'];
        $instanceId = 'instanceId';
        $userId = 'userId';

        $repo->shouldReceive('fetchByIds')->andReturn([
            [
                'id' => $ids[0],
                'instanceId' => $instanceId,
                'userId' => $userId,
            ],
            [
                'id' => $ids[1],
                'instanceId' => $instanceId,
                'userId' => $userId,
            ]
        ]);

        $result = $handler->getsByIds($ids);

        $this->assertEquals(2, count($result));
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result[0]);
    }

    /**
     * test get documents
     *
     * @return void
     */
    public function testGets()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $ids = ['id1', 'id2'];
        $instanceId = 'instanceId';
        $userId = 'userId';

        $repo->shouldReceive('fetch')->andReturn([
            [
                'id' => $ids[0],
                'instanceId' => $instanceId,
                'userId' => $userId,
            ],
            [
                'id' => $ids[1],
                'instanceId' => $instanceId,
                'userId' => $userId,
            ]
        ]);

        $wheres = ['instanceId' => $instanceId];
        $orders = [];

        $configHandler->shouldReceive('get')->andReturn($this->getConfigEntity());

        $result = $handler->gets($wheres, $orders);

        $this->assertEquals(2, count($result));
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result[0]);
    }

    /**
     * test get documents using paginate
     *
     * @return void
     */
    public function testPaginate()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $ids = ['id1', 'id2'];
        $instanceId = 'instanceId';
        $userId = 'userId';

        $items = [
            [
                'id' => $ids[0],
                'instanceId' => $instanceId,
                'userId' => $userId,
            ],
            [
                'id' => $ids[1],
                'instanceId' => $instanceId,
                'userId' => $userId,
            ]
        ];


        $repo->shouldReceive('paginate')->andReturn($this->getPaginator($items));

        $wheres = ['instanceId' => $instanceId];
        $orders = [];

        $configHandler->shouldReceive('get')->andReturn($this->getConfigEntity());

        $result = $handler->paginate($wheres, $orders);

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
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $instanceId = 'instanceId';

        $wheres = ['instanceId' => $instanceId];

        $configHandler->shouldReceive('get')->andReturn($this->getConfigEntity());

        $repo->shouldReceive('count')->andReturn(2);

        $result = $handler->count($wheres);

        $this->assertEquals(2, $result);
    }

    /**
     * test count by instance id
     *
     * @return void
     */
    public function testCountByInstanceId()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $instanceId = 'instanceId';

        $repo->shouldReceive('countByInstanceId')->andReturn(2);

        $result = $handler->countByInstanceId($instanceId);

        $this->assertEquals(2, $result);
    }

    /**
     * test gets by user
     *
     * @eretun void
     */
    public function testGetsByUser()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = m::mock('Xpressengine\Document\DocumentHandler', [
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        ])->shouldAllowMockingProtectedMethods()->makePartial();


        $ids = ['id1', 'id2'];
        $instanceId = 'instanceId';
        $userId = 'userId';

        $handler->shouldReceive('gets')->andReturn([
            [
                'id' => $ids[0],
                'instanceId' => $instanceId,
                'userId' => $userId,
            ],
            [
                'id' => $ids[1],
                'instanceId' => $instanceId,
                'userId' => $userId,
            ]
        ]);

        $wheres = ['instanceId' => $instanceId];
        $orders = [];

        $result = $handler->getsByUser($userId, $wheres, $orders);

        $this->assertEquals(2, count($result));
    }

    /**
     * test get revision
     *
     * @return void
     */
    public function testGetRevision()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $repo->shouldReceive('fetchRevision')->andReturn(['id'=>'documentId']);

        $result = $handler->getRevision('revisionId');
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);
    }

    /**
     * test get revisions by document id
     *
     * @return void
     */
    public function testGetRevisions()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $instanceId = 'instanceId';
        $id = 'documentId';
        $userId = 'userId';

        $configHandler->shouldReceive('get')->andReturn($this->getConfigEntity());
        $repo->shouldReceive('findById')->andReturn([
            'id' => $id,
            'instanceId' => $instanceId,
            'userId' => $userId,
        ]);

        $repo->shouldReceive('getsRevision')->andReturn(
            [
                ['id'=>'documentId', 'revisionId' => 'rid1'],
                ['id'=>'documentId', 'revisionId' => 'rid2'],
            ]
        );

        $result = $handler->getRevisions('revisionId');
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result[0]);
    }

    /**
     * test get depth
     *
     * @return void
     */
    public function testGetDepth()
    {
        $conn = $this->conn;
        $repo = $this->repo;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = new DocumentHandler(
            $conn,
            $repo,
            $configHandler,
            $instanceManager,
            $request
        );

        $doc = $this->getDocumentEntity();
        $doc->reply = '';

        $replyHelper = m::mock('Xpressengine\Document\Repositories\ReplyHelper');
        $replyHelper->shouldReceive('getReplyCharLen')->andReturn(3);

        $repo->shouldReceive('getReplyHelper')->andReturn($replyHelper);

        $result = $handler->getDepth($doc);

        $this->assertEquals(0, $result);

        $doc->reply = 'aaa';
        $result = $handler->getDepth($doc);

        $this->assertEquals(1, $result);
    }

}
