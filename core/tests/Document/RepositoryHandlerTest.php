<?php
/**
 *
 */
namespace Xpressengine\Tests\Document;

use Mockery as M;
use PHPUnit_Framework_TestCase;
use Xpressengine\Document\RepositoryHandler;

/**
 * Class DocumentHandler
 * @package Xpressengine\Tests\Document
 * @todo Exception test 하지 않았음
 */
class RepositoryHandlerTest extends PHPUnit_Framework_TestCase
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
     * @var M\MockInterface|\Xpressengine\Document\Repositories\DocumentRepository
     */
    protected $documentRepository;

    /**
     * @var M\MockInterface|\Xpressengine\Document\Repositories\RevisionRepository
     */
    protected $revisionRepository;

    /**
     * @var M\MockInterface|\Xpressengine\Document\Repositories\ReplyHelper
     */
    protected $replyHelper;
    
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
        $query = m::mock('Xpressengine\Database\DynamicQuery');

        $conn = m::mock('Xpressengine\Database\VirtualConnectionInterface');
        $conn->shouldReceive('table')->andReturn($query);
        $conn->shouldReceive('dynamic')->andReturn($query);
        $conn->shouldReceive('beginTransaction');
        $conn->shouldReceive('commit');

        $documentRepository = m::mock('Xpressengine\Document\Repositories\DocumentRepository');
        $revisionRepository = m::mock('Xpressengine\Document\Repositories\RevisionRepository');
        $replyHelper = m::mock('Xpressengine\Document\Repositories\ReplyHelper');
        
        $this->conn = $conn;
        $this->query = $query;
        $this->documentRepository = $documentRepository;
        $this->revisionRepository = $revisionRepository;
        $this->replyHelper = $replyHelper;
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
     * test get property
     *
     * @return void
     */
    public function testGetProperty()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;
        
        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $this->assertInstanceOf('Xpressengine\Database\VirtualConnectionInterface', $repository->connection());
        $this->assertInstanceOf(
            'Xpressengine\Document\Repositories\ReplyHelper',
            $repository->getReplyHelper()
        );
    }

    /**
     * test insert
     *
     * @return void
     */
    public function testInsert()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $doc = $this->getDocumentEntity();
        $doc->id = 'documentId';
        $doc->instanceId = 'instanceId';
        $doc->writer = 'writer';

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->once()->with('revision')->andReturn(false);

        $documentRepository->shouldReceive('insert')->andReturn($doc);

        $result = $repository->insert($doc, $config);
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);

        // test with revision
        $config->shouldReceive('get')->once()->with('revision')->andReturn(true);
        $revisionRepository->shouldReceive('isChanged')->andReturn(true);
        $revisionRepository->shouldReceive('insert');

        $result = $repository->insert($doc, $config);
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);
    }

    /**
     * test insert without document id
     *
     * @expectedException \Xpressengine\Document\Exceptions\RequiredValueException
     * @return void
     */
    public function testInsertWithoutDocumentId()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $doc = $this->getDocumentEntity();
        $config = $this->getConfigEntity();

        $repository->insert($doc, $config);
    }

    /**
     * test insert without writer
     *
     * @expectedException \Xpressengine\Document\Exceptions\RequiredValueException
     * @return void
     */
    public function testInsertWithoutWriter()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $doc = $this->getDocumentEntity();
        $doc->id = 'documentId';

        $config = $this->getConfigEntity();

        $repository->insert($doc, $config);
    }

    /**
     * test insert reply
     *
     * @return void
     */
    public function testInsertReply()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        /** @var M\MockInterface|\Xpressengine\Document\RepositoryHandler $repository */
        $repository = m::mock('Xpressengine\Document\RepositoryHandler', [
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        ])->shouldAllowMockingProtectedMethods()->makePartial();

        $doc = $this->getDocumentEntity();
        $doc->id = 'documentId';
        $doc->instanceId = 'instanceId';
        $doc->writer = 'writer';
        $doc->parentId = 'parentId';

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->once()->with('revision')->andReturn(false);

        $documentRepository->shouldReceive('insert')->andReturn($doc);

        // get parent
        $repository->shouldReceive('findById')->andReturn([
            'id' => 'parentId'
        ]);
        $documentRepository->shouldReceive('getLastChildReply')->andReturn('lastChar');

        $replyHelper->shouldReceive('getReplyCharLen');
        $replyHelper->shouldReceive('setReply');

        $result = $repository->insert($doc, $config);
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);
    }


    /**
     * test insert reply to parent not exist
     *
     * @expectedException \Xpressengine\Document\Exceptions\DocumentNotExistsException
     * @return void
     */
    public function testInsertReplyParentNotExist()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        /** @var M\MockInterface|\Xpressengine\Document\RepositoryHandler $repository */
        $repository = m::mock('Xpressengine\Document\RepositoryHandler', [
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        ])->shouldAllowMockingProtectedMethods()->makePartial();

        $doc = $this->getDocumentEntity();
        $doc->id = 'documentId';
        $doc->instanceId = 'instanceId';
        $doc->writer = 'writer';
        $doc->parentId = 'parentId';

        $config = $this->getConfigEntity();

        $documentRepository->shouldReceive('insert')->andReturn($doc);

        // get parent
        $repository->shouldReceive('findById')->andReturn(null);

        $repository->insert($doc, $config);
    }

    /**
     * test update
     *
     * @return void
     */
    public function testUpdate()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $doc = $this->getDocumentEntity();
        $doc->id = 'documentId';
        $doc->instanceId = 'instanceId';
        $doc->writer = 'writer';

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->once()->with('revision')->andReturn(false);
        $config->shouldReceive('get')->once()->with('division')->andReturn(false);

        $documentRepository->shouldReceive('update')->andReturn($doc);
        $result = $repository->update($doc, $config);
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);

        // with revision, division insert
        $doc->shouldReceive('diff')->once()->andReturn(['instanceId' => 'changedInstanceId']);
        $config->shouldReceive('get')->once()->with('revision')->andReturn(true);
        $config->shouldReceive('get')->once()->with('division')->andReturn(true);

        $revisionRepository->shouldReceive('isChanged')->andReturn(true);
        $revisionRepository->shouldReceive('insert');

        $documentRepository->shouldReceive('insertDivision');

        $result = $repository->update($doc, $config);
        $revisionRepository->shouldReceive('insert');
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);

        // division update
        $doc->shouldReceive('diff')->once()->andReturn([]);
        $config->shouldReceive('get')->once()->with('revision')->andReturn(false);
        $config->shouldReceive('get')->once()->with('division')->andReturn(true);

        $documentRepository->shouldReceive('updateDivision');

        $result = $repository->update($doc, $config);
        $revisionRepository->shouldReceive('insert');
        $this->assertInstanceOf('Xpressengine\Document\DocumentEntity', $result);

        // test change instance id and origin instance support division
        $doc->shouldReceive('diff')->once()->andReturn(['instanceId' => 'chagend']);
        $doc->shouldReceive('diff')->once()->andReturn(['instanceId' => 'chagend']);
        $doc->shouldReceive('getOriginal')->once()->andReturn(['instanceId' => $doc->instanceId]);
        $config->shouldReceive('get')->once()->with('revision')->andReturn(false);
        $config->shouldReceive('get')->once()->with('division')->andReturn(true);

        $originConfig = $this->getConfigEntity();
        $originConfig->shouldReceive('get')->once()->with('division')->andReturn(true);

        $documentRepository->shouldReceive('deleteDivision');

        $result = $repository->update($doc, $config, $originConfig);
        $revisionRepository->shouldReceive('insert');
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
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $doc = $this->getDocumentEntity();
        $doc->id = 'documentId';
        $doc->instanceId = 'instanceId';
        $doc->writer = 'writer';

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('revision')->andReturn(true);

        $revisionRepository->shouldReceive('delete');
        $documentRepository->shouldReceive('delete')->andReturn(1);
        $result = $repository->delete($doc, $config);
        $this->assertEquals(1, $result);
    }

    /**
     * test find document
     *
     * @return void
     */
    public function testFind()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $id = 'documentId';

        $config = $this->getConfigEntity();

        $documentRepository->shouldReceive('find')->andReturn([
            'id' => $id,
            'instanceId' => 'instanceId'
        ]);

        $result = $repository->find($id, $config);
        $this->assertEquals($id, $result['id']);
    }

    /**
     * test find document by id
     *
     * @return void
     */
    public function testFindById()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $id = 'documentId';

        $documentRepository->shouldReceive('findById')->andReturn([
            'id' => $id,
            'instanceId' => 'instanceId'
        ]);

        $result = $repository->findById($id);
        $this->assertEquals($id, $result['id']);
    }

    /**
     * test find document by ids
     *
     * @return void
     */
    public function testFindByIds()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $id1 = 'documentId-1';
        $id2 = 'documentId-2';

        $documentRepository->shouldReceive('fetchByIds')->andReturn([
            ['id' => $id1, 'instanceId' => 'instanceId',],
            ['id' => $id2, 'instanceId' => 'instanceId',]
        ]);

        $result = $repository->fetchByIds([$id1, $id2]);
        $this->assertEquals($id1, $result[0]['id']);
    }

    /**
     * test fetch documents
     *
     * @return void
     */
    public function testFetch()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $wheres = [];
        $orders = [];

        $config = $this->getConfigEntity();

        $documentRepository->shouldReceive('fetch')->andReturn([]);

        $result = $repository->fetch($wheres, $orders, $config);
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
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $wheres = [];
        $orders = [];

        $config = $this->getConfigEntity();

        $documentRepository->shouldReceive('paginate')->andReturn($this->getPaginator([]));

        $result = $repository->paginate($wheres, $orders, $config);
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
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $wheres = [];

        $config = $this->getConfigEntity();

        $documentRepository->shouldReceive('count')->andReturn(0);

        $result = $repository->count($wheres, $config);
        $this->assertEquals(0, $result);
    }

    /**
     * test count
     *
     * @return void
     */
    public function testCountByInstanceId()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $documentRepository->shouldReceive('countByInstanceId')->andReturn(0);

        $result = $repository->countByInstanceId('instanceId');
        $this->assertEquals(0, $result);
    }

    /**
     * test fetch revision
     *
     * @return void
     */
    public function testFetchRevision()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $revisionId = 'revisionId';
        $id = 'documentId';

        $revisionRepository->shouldReceive('find')->andReturn([
            'revisionId' => $revisionId,
            'id' => $id,
            'instanceId' => 'instanceId'
        ]);

        $result = $repository->fetchRevision($revisionId);
        $this->assertEquals($revisionId, $result['revisionId']);
    }

    /**
     * test fetch revision
     *
     * @return void
     */
    public function testGetRevision()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $revisionId1 = 'revisionId-1';
        $revisionId2 = 'revisionId-2';
        $id = 'documentId';

        $config = $this->getConfigEntity();

        $revisionRepository->shouldReceive('fetchById')->andReturn([
            [
                'revisionId' => $revisionId1,
                'id' => $id,
                'instanceId' => 'instanceId'
            ],
            [
                'revisionId' => $revisionId2,
                'id' => $id,
                'instanceId' => 'instanceId'
            ]
        ]);

        $result = $repository->getsRevision($id, $config);
        $this->assertEquals($revisionId1, $result[0]['revisionId']);
    }

    /**
     * test get last child reply
     *
     * @return void
     */
    public function testGetLastChildReply()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $doc = $this->getDocumentEntity();

        $lastChildReply = 'aaa';
        $replyCharLen = 3;

        $documentRepository->shouldReceive('getLastChildReply')->andReturn($lastChildReply);
        $result = $repository->getLastChildReply($doc, $replyCharLen);
        $this->assertEquals($lastChildReply, $result);
    }

    /**
     * test get replies
     *
     * @return void
     */
    public function testGetReplies()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $doc = $this->getDocumentEntity();

        $documentRepository->shouldReceive('getReplies')->andReturn([]);
        $result = $repository->getReplies($doc);
        $this->assertEquals(0, count($result));
    }

    /**
     * test delete division
     *
     * @return void
     */
    public function testDeleteDivision()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $doc = $this->getDocumentEntity();
        $config = $this->getConfigEntity();

        $documentRepository->shouldReceive('deleteDivision');
        $repository->deleteDivision($doc, $config);
    }

    /**
     * test insert division
     *
     * @return void
     */
    public function testInsertDivision()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $doc = $this->getDocumentEntity();
        $config = $this->getConfigEntity();

        $documentRepository->shouldReceive('insertDivision');
        $repository->insertDivision($doc, $config);
    }

    /**
     * test create division table
     *
     * @return void
     */
    public function testCreateDivisionTable()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);
        $config->shouldReceive('get')->with('instanceId')->andReturn('instanceId');

        // get create table query sting
        $conn->shouldReceive('select')->once()->andReturn([['Create Table' => 'create table query string']]);
        // check table exist
        $conn->shouldReceive('select')->once()->andReturn([]);
        $conn->shouldReceive('insert');
        $conn->shouldReceive('getTablePrefix')->andReturn('');

        $documentRepository->shouldReceive('divisionTable')->andReturn('documents_division_instance_id');

        $repository->createDivisionTable($config);
    }

    /**
     * test create division table already exist
     *
     * @expectedException \Xpressengine\Document\Exceptions\DivisionExistsException
     * @return void
     */
    public function testCreateDivisionTableAlreadyExist()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);
        $config->shouldReceive('get')->with('instanceId')->andReturn('instanceId');

        // get create table query sting
        $conn->shouldReceive('select')->once()->andReturn([['Create Table' => 'create table query string']]);
        // check table exist
        $conn->shouldReceive('select')->once()->andReturn(['exsit_same_table_name']);
        $conn->shouldReceive('getTablePrefix')->andReturn('');

        $repository->createDivisionTable($config);
    }

    /**
     * test drop division table
     *
     * @return void
     */
    public function testDropDivisionTable()
    {
        $conn = $this->conn;
        $documentRepository = $this->documentRepository;
        $revisionRepository = $this->revisionRepository;
        $replyHelper = $this->replyHelper;

        $repository = new RepositoryHandler(
            $conn,
            $documentRepository,
            $revisionRepository,
            $replyHelper
        );

        $config = $this->getConfigEntity();
        $config->shouldReceive('get')->with('division')->andReturn(true);

        $documentRepository->shouldReceive('divisionTable')->andReturn('documents_division_instance_id');

        $conn->shouldReceive('delete');
        $conn->shouldReceive('getTablePrefix')->andReturn('');

        $repository->dropDivisionTable($config);
    }
}
