<?php
/**
 * DocumentHandler
 *
 * PHP version 5
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Document;

use Illuminate\Http\Request;
use Xpressengine\Document\Exceptions\DocumentNotFoundException;
use Xpressengine\Document\Models\Document;
use Xpressengine\Document\Models\Revision;
use Xpressengine\Config\ConfigEntity;
use Closure;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Hashing\Hasher;
use Xpressengine\Database\VirtualConnectionInterface as VirtualConnection;

/**
 * DocumentHandler
 * Document를 Instance에 따라 관리합니다.
 * 이 Handler는 Instance 생성할 때 등록 한 설정에 따라 테이블 분리(division), 변경 이력 관리(revision)를 지원합니다.
 *
 * ## app binding
 * * xe.document 로 바인딩 되어 있음
 * * Document facade 제공
 *
 * ## 사용법
 *
 * ### Instance 생성
 * ```php
 * Document::createInstance('newInstanceId');
 * ```
 *
 * ### 문서 등록
 * ```php
 * $id = (new Keygen())->generate();
 * $inputs = ['id'=>$id', 'instanceId'=>'instance-id', 'title'=>'title', 'content'=>'content' ...];
 * $doc = new DocumentEntity($inputs);
 * $documentHandler->add($doc);
 * ```
 *
 * ### 문서 수정
 * ```php
 * $doc = $documentHandler->get('document-id', 'instance-id');
 * $doc->title = 'changed title';
 *
 * app('xe.document')->update($doc);
 * ```
 *
 * ### 문서 삭제
 * ```php
 * $doc = $documentHandler->get('document-id', 'instance-id');
 *
 * app('xe.document')->remove($doc);
 * ```
 *
 * ### 문서 조회
 * ```php
 * // instance id, document id 로 문서 갖고오기
 * $doc = $documentHandler->get('document-id', 'instance-id');
 *
 * // document id 로 문서 조회
 * $doc = $documentHandler->getById('document-id');
 * ```
 *
 * ### 문서 수 조회
 * ```php
 * // 전체 문서 수 조회회
 * $count = $documentHandler->count();
 *
 * // 인스턴스의 전체 문서 수 조회
 * $count = $documentHandler->countByInstanceId('instance-id');
 * ```
 *
 * ### 문서 목록 조회
 * ```php
 * // $wheres, $orders 는 Repository\DocumentRepository 참고
 * $wheres = [];
 * $orders = [];
 * $docs = $documentHandler->gets($wheres, $orders, 20);
 *
 * $paginate = $documentHandler->paginate($wheres, $orders, 20);
 * ```
 *
 * ## 기타
 *
 * ### Interception
 * * Comment count 를 위해 DocumentServiceProvider 에서 Interception 등록
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class DocumentHandler
{

    /**
     * @var VirtualConnection
     */
    protected $conn;

    /**
     * @var RevisionHandler
     */
    protected $revision;

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
     * Memory cache
     *
     * @var DocumentEntity[]
     */
    protected $docs = [];

    /**
     * @param VirtualConnection   $conn            database connection
     * @param ConfigHandler       $configHandler   config handler
     * @param InstanceManager     $instanceManager instance manager
     * @param Request             $request         Request
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
     * @return void
     */
    public function destroyInstance($instanceId)
    {
        $config = $this->configHandler->get($instanceId);
        $this->instanceManager->remove($config);

        $documentHandler = $this;
        Document::where('instanceId', $config->get('instanceId'))->chunk(100, function ($docs) use ($documentHandler) {
            foreach ($docs as $doc) {
                $documentHandler->remove($doc);
            }
        });
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
        $doc->fill($doc->filter($attributes));
        $result = $doc->save();

        $this->addRevision($doc->toArray());

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
        $doc->checkRequired($doc->toArray());
        $doc->save();

        // 검증해야함
        $this->removeDivision($doc);

        $this->addRevision($doc->toArray());

        $doc->getConnection()->commit();

        return $doc;
    }

    public function addRevision(array $args)
    {
        // insert to revision database table
        $revisionDoc = new Revision($args);
        $revisionDoc->save();
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
        $originDoc = Document::find($doc->id);
        if ($originDoc->instanceId != $doc->instanceId) {
            $originConfig = $this->configHandler->getOrDefault($originDoc->instanceId);
        }

        if ($originConfig != null && $originConfig->get('division') === true) {
            $diff = $doc->diff();
            if (isset($diff['instanceId'])) {
                //$originDoc->setDivision()->delete();
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
     *
     * @param string $instanceId document instance id
     * @return Document
     */
    public function getModel($instanceId = null)
    {
        $config = $this->getConfig($instanceId);
        $doc = new Document;
        $doc->setConfig($config, $this->getDivisionTableName($config));
        return $doc;
    }

    /**
     * set model's config
     *
     * @param Document $doc document model
     * @param string $instanceId document instance id
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
        /** @var Document $doc */
        $doc = $this->getModel($instanceId)->find($id);
        if ($doc == null) {
            throw new DocumentNotFoundException;
        }
        return $doc;
    }
}
