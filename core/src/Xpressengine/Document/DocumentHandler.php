<?php
/**
 * DocumentHandler
 *
 * PHP version 5
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Document;

use Illuminate\Http\Request;
use Xpressengine\Document\Exceptions\DocumentNotFoundException;
use Xpressengine\Document\Models\Document;
use Xpressengine\Document\Models\Revision;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\VirtualConnectionInterface as VirtualConnection;

/**
 * DocumentHandler
 *
 * * 문서 등록, 수정, 삭제 할 때 intercept 할 수 있음
 * Document Model 자체적으로 CRUD 할 때 intercept 를 제공할 수 없는 문제 해결
 * * Division 처리 및 DyanmciQuery 관련 작업을 위해 Document Model 에 config 를 설정해야하고
 * 이 설정을 위해 getModel() setModelConfig() 메소드가 있음
 * * Division(테이블 분할)은 Document Model 에서 처리됨.
 * * Document Model 을 이용해 Database CRUD 처리를 직접하는 경우
 * revision 에 대한 처리를 할 수 없으며 intercept 할 수 없음
 *
 * ## app binding
 * * xe.document 로 바인딩 되어 있음
 * * Document facade 제공
 *
 * ## 사용법
 *
 * ### Instance 생성
 * ```php
 * XeDocument::createInstance('newInstanceId');
 * ```
 *
 * ### 문서 등록
 * ```php
 * $inputs = ['id'=>$id', 'instanceId'=>'instance-id', 'title'=>'title', 'content'=>'content' ...];
 * XeDocument::add($inputs);
 * ```
 *
 * ### 문서 수정
 * ```php
 * $model = XeDocument::getModel('instance-id');
 * $doc = $model->find('document-id');
 *
 * $doc->title = 'changed title';
 *
 * XeDocument::update($doc);
 * ```
 *
 * ### 문서 삭제
 * ```php
 * $model = XeDocument::getModel('instance-id');
 * $doc = $model->find('document-id');
 *
 * XeDocument::remove($doc);
 * ```
 *
 * ### 문서 조회
 * ```php
 * $model = XeDocument::getModel('instance-id');
 * $doc = $model->find('document-id');
 *
 * $doc = XeDocument::get('document-id', 'instance-id');
 *
 * // instance id 를 넘겨주지 않으면 항상 documents table 에서 조회
 * $doc = XeDocument::get('document-id');
 * ```
 *
 * ### 문서 수 조회
 * ```php
 * // 전체 문서 수 조회회
 * $count = Document::count();
 *
 * // 인스턴스의 전체 문서 수 조회
 * $model = XeDocument::getModel('instance-id');
 * $count = $model->count('instance-id');
 * ```
 *
 * ### 문서 목록 조회
 * ```php
 * $perPage = 10;
 *
 * $model = XeDocument::getModel('instance-id');
 *
 * $model->paginate($perPage);
 * ```
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class DocumentHandler
{

    /**
     * @var document model class
     */
    protected $model = Document::class;

    /**
     * @var revision model class
     */
    protected $revisionModel = Revision::class;

    /**
     * @var VirtualConnection
     */
    protected $conn;

    /**
     * @var ConfigHandler
     */
    protected $configHandler;

    /**
     * @var InstanceManager
     */
    protected $instanceManager;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @param VirtualConnection $conn            database connection
     * @param ConfigHandler     $configHandler   config handler
     * @param InstanceManager   $instanceManager instance manager
     * @param Request           $request         Request
     */
    public function __construct(
        VirtualConnection $conn,
        ConfigHandler $configHandler,
        InstanceManager $instanceManager,
        Request $request
    ) {
        $this->conn = $conn;
        $this->configHandler = $configHandler;
        $this->instanceManager = $instanceManager;
        $this->request = $request;
    }

    /**
     * get config handler
     *
     * @return ConfigHandler
     */
    public function getConfigHandler()
    {
        return $this->configHandler;
    }

    /**
     * get repository
     *
     * @return InstanceManager
     */
    public function getInstanceManager()
    {
        return $this->instanceManager;
    }

    /**
     * create document instance
     *
     * @param string $instanceId instance id
     * @param array  $params     parameters
     * @return ConfigEntity
     */
    public function createInstance($instanceId, $params = [])
    {
        $config = $this->configHandler->make($instanceId, $params);
        $this->instanceManager->add($config);

        return $config;
    }

    /**
     * destroy document instance
     *
     * @param string $instanceId instance id
     * @param int    $chunk      chunk count
     * @return void
     */
    public function destroyInstance($instanceId, $chunk = 100)
    {
        $config = $this->configHandler->get($instanceId);
        $this->instanceManager->remove($config);

        $documentHandler = $this;
        Document::where('instanceId', $config->get('instanceId'))->chunk(
            $chunk,
            function ($docs) use ($documentHandler) {
                foreach ($docs as $doc) {
                    $documentHandler->remove($doc);
                }
            }
        );
    }

    /**
     * get database proxy options
     *
     * @param ConfigEntity $config config entity
     * @return array
     */
    public function proxyOption(ConfigEntity $config = null)
    {
        $options = [];
        if ($config != null) {
            $options['id'] = $config->get('instanceId');
        }

        return $options;
    }

    /**
     * add document
     *
     * @param array $attributes document attributes
     * @return Document
     */
    public function add(array $attributes)
    {
        $doc = $this->getModel($attributes['instanceId']);

        $doc->getConnection()->beginTransaction();

        $attributes = $doc->fixedAttributes($attributes);

        if (empty($attributes['ipaddress']) === true) {
            $attributes['ipaddress'] = $this->request->ip();
        }

        $doc->checkRequired($attributes);
        $doc->fill($attributes);
        $doc->save();

        $this->addRevision($doc);

        $doc->getConnection()->commit();

        return $doc;
    }

    /**
     * update document
     *
     * @param Document $doc document model
     * @return Document
     */
    public function put(Document $doc)
    {
        $doc->getConnection()->beginTransaction();

        $doc->pureContent = $doc->getPureContent($doc->content);
        $doc->checkRequired($doc->getAttributes());
        $doc->save();

        $this->removeDivision($doc);

        $this->addRevision($doc);

        $doc->getConnection()->commit();

        return $doc;
    }

    /**
     * add revision
     *
     * @param Document $doc document model
     * @return bool
     */
    public function addRevision(Document $doc)
    {
        $config = $this->getConfig($doc->instanceId);
        if ($config === null) {
            return false;
        }
        if ($config->get('revision') !== true) {
            return false;
        }

        $revisionNo = 0;
        $lastRevision = $this->newRevisionModel()->where('id', $doc->id)->max('revisionNo');
        if ($lastRevision !== null) {
            $revisionNo = $lastRevision + 1;
        }

        // insert to revision database table
        $revisionDoc = $this->newRevisionModel(array_merge($doc->getDynamicAttributes(), $doc->getAttributes()));
        $revisionDoc->setProxyOptions([
            'id' => $config->get('instanceId'),
            'group' => $config->get('group'),
            'revision' => true,
        ]);
        $revisionDoc->revisionNo = $revisionNo;
        $revisionDoc->save();

        return true;
    }

    /**
     * 인스턴스 아이디가 변경된 경우 이전 인스턴스의 디비전 테이블 데이터 삭제
     *
     * @param Document $doc document model
     * @return void
     */
    protected function removeDivision(Document $doc)
    {
        $originConfig = null;
        /** @var Document $originDoc */
        $originDoc = $this->getModel()->find($doc->id);
        if ($originDoc->instanceId != $doc->instanceId) {
            $originConfig = $this->configHandler->getOrDefault($originDoc->instanceId);
        }

        if ($originConfig != null && $originConfig->get('division') === true) {
            if ($doc->getOriginal('instanceId') != $doc->getAttribute('instanceId')) {
                $division = $this->newModel();
                $division->setTable($this->getDivisionTableName($originConfig));
                $division->delete($doc->id);
            }
        }
    }

    /**
     * delete document
     *
     * @param Document $doc document model
     * @return bool
     */
    public function remove(Document $doc)
    {
        $this->conn->beginTransaction();

        $result = $doc->delete();

        $this->conn->commit();

        return $result;
    }

    /**
     * get document config
     *
     * @param string $instanceId instance id
     * @return ConfigEntity
     */
    public function getConfig($instanceId)
    {
        return $this->configHandler->getOrDefault($instanceId);
    }

    /**
     * get division table name
     *
     * @param ConfigEntity $config config entity
     * @return string
     */
    public function getDivisionTableName(ConfigEntity $config)
    {
        return $this->instanceManager->getDivisionTableName($config);
    }

    /**
     * Proxy, Division 관련 설정이 된 Document model 반환
     * Document 는 config 를 설정해야 정상 사용 가능함
     * document model 를 직접 반환하지 않음
     *
     * @param string $instanceId document instance id
     * @return Document
     */
    public function getModel($instanceId = null)
    {
        $config = $this->getConfig($instanceId);
        $doc = $this->newModel();
        $doc->setConfig($config, $this->getDivisionTableName($config));
        return $doc;
    }

    /**
     * create document model
     * config 없이 모델을 직접 생성할 경우 문제가 발생하므로 접근을 제한함
     *
     * @return Document
     */
    protected function newModel()
    {
        return new $this->model;
    }

    /**
     * get revision model
     *
     * @return Revision
     */
    protected function getRevisionModel()
    {
        return $this->revisionModel;
    }

    /**
     * create revision model
     *
     * @param array $attributes attributes
     * @return Revision
     */
    protected function newRevisionModel(array $attributes = [])
    {
        return new $this->revisionModel($attributes);
    }

    /**
     * set model's config
     *
     * @param Document $doc        document model
     * @param string   $instanceId document instance id
     * @return Document
     */
    public function setModelConfig(Document $doc, $instanceId)
    {
        $config = $this->getConfig($instanceId);
        $doc->setConfig($config, $this->getDivisionTableName($config));
        return $doc;
    }

    /**
     * get document
     *
     * @param string $id         document id
     * @param string $instanceId instance id
     * @return Document
     */
    public function get($id, $instanceId = null)
    {
        $doc = $this->getModel($instanceId)->find($id);
        if ($doc == null) {
            throw new DocumentNotFoundException;
        }
        return $doc;
    }
}
