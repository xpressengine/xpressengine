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
use Xpressengine\Database\DynamicQuery;
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
 * * ~Division 처리 및 DynamicQuery 관련 작업을 위해 Document Model 에 config 를 설정해야하고
 * 이 설정을 위해 getModel() setModelConfig() 메소드가 있음~
 * * Division 된 테이블을 사용하기 위해서 Document::division() 메소드에 인스턴스 아이디 주입
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
 * $doc = Document::find('document-id');
 *
 * $doc->title = 'changed title';
 *
 * XeDocument::update($doc);
 * ```
 *
 * ### 문서 삭제
 * ```php
 * $doc = Document::find('document-id');
 *
 * XeDocument::remove($doc);
 * ```
 *
 * ### 문서 조회
 * ```php
 * $doc = Document::find('document-id');
 *
 * $doc = XeDocument::get('document-id', 'instance-id');
 *
 * // 모델에 division 을 설정하면 분리된 테이블 사용
 * $model = Document::division('instanceId');
 * $doc = $model->get('document-id');
 * ```
 *
 * ### 문서 수 조회
 * ```php
 * // 전체 문서 수 조회회
 * $count = Document::count();
 *
 * // division 된 테이블에서 인스턴스의 전체 문서 수 조회
 * $model = Document::division('instance-id');
 * $count = $model->count('instance-id');
 * ```
 *
 * ### 문서 목록 조회
 * ```php
 * $perPage = 10;
 *
 * $paginate = Document::paginate($perPage);
 *
 * // division 된 테이블에서 조회
 * $model = Document::division('instance-id');
 * $paginate = $model->paginate($perPage);
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
        $doc = $this->newModel();

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
        if ($doc->ipaddress == '') {
            $doc->ipaddress = $this->request->ip();
        }
        $doc->checkRequired($doc->getAttributes());
        $doc->save();

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
        $instanceId = $doc->instanceId;
        if ($instanceId === null || $instanceId == '') {
            return false;
        }
        $config = $this->getConfig($instanceId);
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
        $revisionDoc = $this->newRevisionModel();
        $revisionDoc->fill(array_merge($doc->getDynamicAttributes(), $doc->getAttributes()));
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
     *
     * @param Document $doc
     * @param ConfigEntity $config
     * @return string
     */
    protected function pivotDivisionTable(Document $doc, ConfigEntity $config)
    {
        return $doc->table == Document::TABLE_NAME ?
            $this->instanceManager->getDivisionTableName($config) :
            Document::TABLE_NAME;
    }

    /**
     * add division
     *
     * @param Document $doc document model
     * @return bool
     */
    public function addDivision(Document $doc)
    {
        $instanceId = $doc->instanceId;
        if ($instanceId === null || $instanceId == '') {
            return false;
        }
        $config = $this->getConfig($instanceId);
        if ($config === null) {
            return false;
        }
        if ($config->get('division') !== true) {
            return false;
        }

        $query = $doc->newQuery()->getQuery();
        /** @var DynamicQuery $clone */
        $clone = clone $query;
        $clone->useProxy(false);
        $clone->from($this->pivotDivisionTable($doc, $config));
        $params = $doc->toArray();
        $params['email'] = $doc->email;
        $params['certifyKey'] = $doc->certifyKey == null ? : '';
        $params['ipaddress'] = $doc->ipaddress;
        $clone->insert($params);

        return true;
    }

    /**
     * put division
     *
     * @param Document $doc document model
     * @return bool
     */
    public function putDivision(Document $doc)
    {
        $instanceId = $doc->instanceId;

        // 인스턴스를 변경할 경우 이전의 division 테이블 row 삭제
        if ($instanceId != $doc->getOriginal('instanceId')) {
            $originConfig = $this->configHandler->getOrDefault($doc->getOriginal('instanceId'));
            if ($originConfig->get('division') === true) {
                /** @var DynamicQuery $query */
                $query = $this->newModel()->getQuery();
                $query->from($this->instanceManager->getDivisionTableName($originConfig));
                $query->delete($doc->id);
            }
        }

        if ($instanceId === null || $instanceId == '') {
            return false;
        }
        $config = $this->getConfig($instanceId);
        if ($config === null) {
            return false;
        }
        if ($config->get('division') !== true) {
            return false;
        }

        // 인스턴스가 변경되었다면 insert, 그렇지 않으면 update
        if ($instanceId != $doc->getOriginal('instanceId')) {
            $this->addDivision($doc);
        } else {
            $query = $doc->newQuery()->getQuery();
            /** @var DynamicQuery $clone */
            $clone = clone $query;
            $clone->useProxy(false);
            $clone->from($this->pivotDivisionTable($doc, $config));
            $dirty = $doc->getDirty();
            if (count($dirty) > 0) {
                $clone->where('id', '=', $doc->id)->update($dirty);
            }

        }
        return true;
    }

    /**
     * remove division
     *
     * @param Document $doc document model
     * @return bool
     */
    public function removeDivision(Document $doc)
    {
        $instanceId = $doc->instanceId;
        if ($instanceId === null || $instanceId == '') {
            return false;
        }
        $config = $this->getConfig($instanceId);
        if ($config === null) {
            return false;
        }
        if ($config->get('division') !== true) {
            return false;
        }

        /** @var DynamicQuery $query */
        $query = $this->newModel()->getQuery();
        $query->from($this->pivotDivisionTable($doc, $config));
        $query->delete($doc->id);
        return true;
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
     * @deprecated
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
     * @deprecated
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
     * @deprecated
     */
    public function setModelConfig(Document $doc, $instanceId)
    {
        $config = $this->getConfig($instanceId);
        $doc->setConfig($config, $this->instanceManager->getDivisionTableName($config));
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
        $model = $this->newModel();
        if ($instanceId !== null) {
            $model->where('instanceId', '=', $instanceId);
        }
        $doc = $model->where('id', '=', $id)->first();
        if ($doc == null) {
            throw new DocumentNotFoundException;
        }
        return $doc;
    }
}
