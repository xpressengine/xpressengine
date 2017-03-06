<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Document;

use ArrayIterator;
use Mockery as m;
use PHPUnit_Framework_TestCase;
use Xpressengine\Document\DocumentHandler;

/**
 * Class DocumentHandler
 * @package Xpressengine\Tests\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DocumentHandlerTest extends PHPUnit_Framework_TestCase
{
    protected $conn;
    protected $configHandler;
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
        $conn->shouldReceive('beginTransaction');
        $conn->shouldReceive('commit');

        $configHandler = m::mock('Xpressengine\Document\ConfigHandler');
        $instanceManager = m::mock('Xpressengine\Document\InstanceManager');
        $request = m::mock('\Illuminate\Http\Request');

        $this->conn = $conn;
        $this->configHandler = $configHandler;
        $this->instanceManager = $instanceManager;
        $this->request = $request;
    }


    /**
     * @return m\MockInterface|\Xpressengine\Document\Models\Document
     */
    private function getDocModel()
    {
        $doc = m::mock('Xpressengine\Document\Models\Document');
        $doc->shouldReceive('getConnection')->andReturn($this->conn);
        return $doc;
    }

    /**
     * @return m\MockInterface|\Xpressengine\Document\Models\Revision
     */
    private function getRevisionModel()
    {
        $revision = m::mock('Xpressengine\Document\Models\Revision');
        $revision->shouldReceive('getConnection')->andReturn($this->conn);
        return $revision;
    }

    /**
     * get User instance
     *
     * @return m\MockInterface|\Xpressengine\User\UserInterface
     */
    private function getUser()
    {
        $user = m::mock(
            'Xpressengine\User\Models\User',
            'Xpressengine\User\UserInterface'
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
     * get document handler instance
     *
     * return DocumentHandler
     */
    private function getHandler()
    {
        $conn = $this->conn;
        $configHandler = $this->configHandler;
        $instanceManager = $this->instanceManager;
        $request = $this->request;

        $handler = m::mock('Xpressengine\Document\DocumentHandler', [
                $conn,
                $configHandler,
                $instanceManager,
                $request
            ])
            ->shouldAllowMockingProtectedMethods()
            ->makePartial();

        return $handler;
    }
    /**
     * test get property
     *
     * @return void
     */
    public function testGetProperty()
    {
        $handler = $this->getHandler();

        $this->assertInstanceOf('Xpressengine\Document\ConfigHandler', $handler->getConfigHandler());
        $this->assertInstanceOf('Xpressengine\Document\InstanceManager', $handler->getInstanceManager());
    }

    /**
     * test add document
     *
     * @return void
     */
    public function testAdd()
    {
        $docId = 'document-id';
        $instanceId = 'instance-id';
        $revision = true;
        $group = 'document-group';

        $configEntity = $this->getConfigEntity();
        $configEntity->shouldReceive('get')->with('revision')->andReturn($revision);
        $configEntity->shouldReceive('get')->with('instanceId')->andReturn($instanceId);
        $configEntity->shouldReceive('get')->with('group')->andReturn($group);
        $this->configHandler->shouldReceive('get')->andReturn(null);
        $this->configHandler->shouldReceive('getOrDefault')->andReturn($configEntity);

        $this->request->shouldReceive('ip')->andReturn('127.0.0.1');

        $this->instanceManager->shouldReceive('getDivisionTableName')
            ->with($configEntity)->andReturn('new-division-table-name');
        $handler = $this->getHandler();

        $attributes = [
            'id' => $docId,
            'instanceId' => $instanceId,
        ];

        $docModel = $this->getDocModel();
        $docModel->shouldReceive('getAttribute')->once()->andReturn($instanceId);
        $docModel->shouldReceive('setConfig');
        $docModel->shouldReceive('fixedAttributes')->once()->with($attributes)->andReturn($attributes);
        $docModel->shouldReceive('getAttribute')->andReturn($attributes);
        $docModel->shouldReceive('checkRequired');
        $docModel->shouldReceive('fill');
        $docModel->shouldReceive('save');
        $docModel->shouldReceive('getDynamicAttributes')->andReturn([]);
        $docModel->shouldReceive('getAttributes')->andReturn($attributes);

        $revisionModel = $this->getRevisionModel();
        $revisionModel->shouldReceive('where')->andReturnSelf();
        $revisionModel->shouldReceive('max')->andReturn(1);
        $revisionModel->shouldReceive('setProxyOptions');
        $revisionModel->shouldReceive('setAttribute');
        $revisionModel->shouldReceive('fill');
        $revisionModel->shouldReceive('save');

        $handler->shouldReceive('newModel')->andReturn($docModel);
        $handler->shouldReceive('getRevisionModel')->andReturn($revisionModel);
        $handler->shouldReceive('newRevisionModel')->andReturn($revisionModel);

        $result = $handler->add($attributes);

        $this->assertInstanceOf('Xpressengine\Document\Models\Document', $result);
    }

    /**
     * test add document
     *
     * @return void
     */
    public function testPut()
    {
        $docId = 'document-id';
        $instanceId = 'instance-id';
        $revision = true;
        $group = 'document-group';
        $content = 'content';

        $configEntity = $this->getConfigEntity();
        $configEntity->shouldReceive('get')->with('revision')->andReturn($revision);
        $configEntity->shouldReceive('get')->with('instanceId')->andReturn($instanceId);
        $configEntity->shouldReceive('get')->with('group')->andReturn($group);
        $this->configHandler->shouldReceive('get')->andReturn(null);
        $this->configHandler->shouldReceive('getOrDefault')->andReturn($configEntity);

        $this->request->shouldReceive('ip')->andReturn('127.0.0.1');

        $this->instanceManager->shouldReceive('getDivisionTableName')
            ->with($configEntity)->andReturn('new-division-table-name');
        $handler = $this->getHandler();

        $attributes = [
            'id' => $docId,
            'instanceId' => $instanceId,
        ];

        $docModel = $this->getDocModel();
        $docModel->shouldReceive('getAttribute')->with('id')->andReturn($docId);
        $docModel->shouldReceive('getAttribute')->with('instanceId')->andReturn($instanceId);
        $docModel->shouldReceive('getAttribute')->with('content')->andReturn($content);
        $docModel->shouldReceive('setConfig');
        $docModel->shouldReceive('fixedAttributes')->with($attributes)->andReturn($attributes);
        $docModel->shouldReceive('checkRequired');
        $docModel->shouldReceive('fill');
        $docModel->shouldReceive('save');
        $docModel->shouldReceive('getDynamicAttributes')->andReturn([]);
        $docModel->shouldReceive('getAttributes')->andReturn($attributes);
        $docModel->shouldReceive('getAttribute')->with('ipaddress')->andReturn('127.0.0.1');
        $docModel->shouldReceive('setAttribute');
        $docModel->shouldReceive('getPureContent')->andReturn($content);
        $docModel->shouldReceive('setAttribute')->with('pureContent', $content);
        $docModel->shouldReceive('toArray')->andReturn($attributes);
        $docModel->shouldReceive('find')->with($docId)->andReturnSelf();

        $revisionModel = $this->getRevisionModel();
        $revisionModel->shouldReceive('where')->andReturnSelf();
        $revisionModel->shouldReceive('max')->andReturn(1);
        $revisionModel->shouldReceive('setProxyOptions');
        $revisionModel->shouldReceive('setAttribute');
        $revisionModel->shouldReceive('fill');
        $revisionModel->shouldReceive('save');

        $handler->shouldReceive('newModel')->andReturn($docModel);
        $handler->shouldReceive('getRevisionModel')->andReturn($revisionModel);
        $handler->shouldReceive('newRevisionModel')->andReturn($revisionModel);

        $result = $handler->put($docModel);

        $this->assertInstanceOf('Xpressengine\Document\Models\Document', $result);
    }

    /**
     * instance id 를 변경해서 수정하는 경우
     *
     * @return void
     */
    public function testPutWithDifferentInstanceId()
    {
        $originInstanceId = 'origin-instance-id';
        $originDivisionTableName = 'origin-division-table-name';

        $docId = 'document-id';
        $instanceId = 'instance-id';
        $revision = true;
        $division = true;
        $group = 'document-group';
        $content = 'content';

        $attributes = [
            'id' => $docId,
            'instanceId' => $instanceId,
        ];

        $configEntity = $this->getConfigEntity();
        $configEntity->shouldReceive('get')->with('revision')->andReturn($revision);
        $configEntity->shouldReceive('get')->with('instanceId')->andReturn($instanceId);
        $configEntity->shouldReceive('get')->with('group')->andReturn($group);

        $this->configHandler->shouldReceive('get')->with($instanceId)->andReturn($configEntity);
        $this->configHandler->shouldReceive('getOrDefault')->with($instanceId)->andReturn($configEntity);

        $originConfigEntity = $this->getConfigEntity();
        $originConfigEntity->shouldReceive('get')->with('revision')->andReturn($revision);
        $originConfigEntity->shouldReceive('get')->with('division')->andReturn($division);
        $originConfigEntity->shouldReceive('get')->with('instanceId')->andReturn($originInstanceId);
        $originConfigEntity->shouldReceive('get')->with('group')->andReturn($group);

        $this->configHandler->shouldReceive('get')->with($originInstanceId)->andReturn($originConfigEntity);
        $this->configHandler->shouldReceive('getOrDefault')->with($originInstanceId)->andReturn($originConfigEntity);
        $this->configHandler->shouldReceive('getOrDefault')->with(null)->andReturn($originConfigEntity);

        $this->request->shouldReceive('ip')->andReturn('127.0.0.1');

        $this->instanceManager->shouldReceive('getDivisionTableName')
            ->with($originConfigEntity)->andReturn($originDivisionTableName);

        $handler = $this->getHandler();

        $docModel = $this->getDocModel();
        $docModel->shouldReceive('getAttribute')->with('id')->andReturn($docId);
        $docModel->shouldReceive('getAttribute')->with('instanceId')->andReturn($instanceId);
        $docModel->shouldReceive('getAttribute')->with('content')->andReturn($content);
        $docModel->shouldReceive('setAttribute')->with('pureContent', $content);
        $docModel->shouldReceive('getAttribute')->with('ipaddress')->andReturn('127.0.0.1');
        $docModel->shouldReceive('getPureContent')->andReturn($content);
        $docModel->shouldReceive('checkRequired');
        $docModel->shouldReceive('toArray')->andReturn($attributes);
        $docModel->shouldReceive('save');
        $docModel->shouldReceive('getOriginal')->with('instanceId')->andReturn($originInstanceId);
        $docModel->shouldReceive('getDynamicAttributes')->andReturn([]);
        $docModel->shouldReceive('getAttributes')->andReturn($attributes);

        $orgModel = $this->getDocModel();
        $orgModel->shouldReceive('getAttribute')->with('id')->andReturn($docId);
        $orgModel->shouldReceive('getAttribute')->with('instanceId')->andReturn($originInstanceId);

        $newModel = $this->getDocModel();
        $newModel->shouldReceive('setConfig');
        $newModel->shouldReceive('find')->with($docId)->andReturn($orgModel);
        $newModel->shouldReceive('setTable');
        $newModel->shouldReceive('delete');

        $revisionModel = $this->getRevisionModel();
        $revisionModel->shouldReceive('where')->andReturnSelf();
        $revisionModel->shouldReceive('max')->andReturn(1);
        $revisionModel->shouldReceive('fill');
        $revisionModel->shouldReceive('setProxyOptions');
        $revisionModel->shouldReceive('setAttribute');
        $revisionModel->shouldReceive('save');

        $handler->shouldReceive('newModel')->andReturn($newModel);
        $handler->shouldReceive('getRevisionModel')->andReturn($revisionModel);
        $handler->shouldReceive('newRevisionModel')->andReturn($revisionModel);

        $result = $handler->put($docModel);

        $this->assertInstanceOf('Xpressengine\Document\Models\Document', $result);
    }

    /**
     * test remove
     *
     * @return void
     */
    public function testRemove()
    {
        $handler = $this->getHandler();

        $docModel = $this->getDocModel();
        $docModel->shouldReceive('delete')->andReturn(1);

        $handler->remove($docModel);
    }

    /**
     * test get
     *
     * @return void
     */
    public function testGet()
    {
        $docId = 'document-id';
        $instanceId = 'instance-id';

        $handler = $this->getHandler();

        $docModel = $this->getDocModel();
        $docModel->shouldReceive('where')->andReturn($docModel);
        $docModel->shouldReceive('first')->andReturn($docModel);
        $handler->shouldReceive('newModel')->andReturn($docModel);

        $doc = $handler->get($docId, $instanceId);

        $this->assertInstanceOf('\Xpressengine\Document\Models\Document', $doc);
    }


    /**
     * test get
     *
     * @expectedException \Xpressengine\Document\Exceptions\DocumentNotFoundException
     */
    public function testGetFailDocumentNotFound()
    {
        $docId = 'document-id';
        $instanceId = 'instance-id';

        $handler = $this->getHandler();

        $docModel = $this->getDocModel();
        $docModel->shouldReceive('where')->andReturn($docModel);
        $docModel->shouldReceive('first')->andReturn(null);
        $handler->shouldReceive('newModel')->andReturn($docModel);

        $handler->get($docId, $instanceId);
    }
}
