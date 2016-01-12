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
use Xpressengine\Document\Exceptions\NotFoundDocumentException;
use Xpressengine\Document\Exceptions\RequiredValueException;
use Xpressengine\Document\Model\Document;
use Xpressengine\Member\Entities\Guest;
use Xpressengine\Member\GuardInterface as Authenticator;
use Xpressengine\Member\Repositories\MemberRepositoryInterface as Member;
use Xpressengine\Member\Entities\MemberEntityInterface;
use Xpressengine\Config\ConfigEntity;
use Closure;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Hashing\Hasher;
use Xpressengine\Database\VirtualConnectionInterface as VirtualConnection;

/**
 * DocumentHandler
 * Document 는 Instance 단위로 설정됨
 * Instance 생성 시 등록 한 설정에 따라 테이블 분리(division), 변경 이력 관리(revision) 지원
 * Document 를 사용하기 위해서 InstanceManager 로 생성 후 사용해야 함
 *
 * ## app binding
 * * xe.document 로 바인딩 되어 있음
 * * Document facade 제공
 *
 * ## 사용법
 *
 * ### Instance 생성
 * ```php
 * $documentHandler = app('xe.document');
 *
 * $configEntity = $documentHandler->createInstance('newInstanceId');
 * $instanceManager->add($configEntity);
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
     * @var RepositoryInterface
     */
    protected $repo;

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
     * @return RepositoryInterface
     */
    public function getRepository()
    {
        return $this->repo;
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
        $documentConfig = $this->configHandler->makeEntity($instanceId, $params);
        $this->instanceManager->add($documentConfig);

        return $documentConfig;
    }

    /**
     * destroy document instance
     *
     * @param string $instanceId instance id
     * @return void
     */
    public function destroyInstance($instanceId)
    {
        $documentConfig = $this->configHandler->get($instanceId);
        $this->instanceManager->remove($documentConfig);
    }

    /**
     * get database proxy options
     *
     * @param ConfigEntity $config config entity
     * @return array
     */
    protected function proxyOption(ConfigEntity $config = null)
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
        $doc = new Document($attributes);
        $this->conn->beginTransaction();

        $doc->fixedAttributes();
        if ($doc->ipaddress == null) {
            $doc->ipaddress = $this->request->ip();
        }

        $doc->checkRequired();

        $config = $this->configHandler->getOrDefault($doc->instanceId);
        $doc->setProxyOptions($this->proxyOption($config));
        $doc->setReply();

        // insert to original documents database table
        $doc->save();

        // insert to division documents database table
        if ($config->get('division') == true) {
            $divisionDoc = new Document($doc->toArray());
            $divisionDoc->setDivision()->save();
        }

        // insert to revision database table
        $this->revision->add($doc->toArray());

        $this->conn->commit();

        $this->removeCache($doc);

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
        $this->conn->beginTransaction();

        $doc->setPureContent();
        $doc->checkRequired();

        $config = $this->configHandler->getOrDefault($doc->instanceId);
        $doc->setProxyOptions($this->proxyOption($config));

        // update to original documents database table
        $doc->save();

        // update to division documents database table
        if ($config->get('division') == true) {
            $divisionDoc = new Document($doc->toArray());
            $divisionDoc->setDivision()->save();
        }

        $this->removeDivision($doc);

        // insert to revision database table
        $this->revision->add($doc);

        $this->conn->commit();

        $this->removeCache($doc);
        return $doc;
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
                $originDoc->setDivision()->delete();
            }
        }
    }

    /**
     * delete document
     *
     * @param Document $doc document model
     * @return int
     * @todo return 을 integer 로 줄 필요 없을 듯
     */
    public function remove(Document $doc)
    {
        $this->conn->beginTransaction();

        $config = $this->configHandler->getOrDefault($doc->instanceId);

        if ($config->get('division') == true) {
            /** @var Document $divisionDoc */
            $divisionDoc = Document::where('id', $doc->id);
            $divisionDoc->setDivision($config)->delete();
        }

        $doc->setProxyOptions($this->proxyOption($config));
        $doc->delete();


        $this->conn->commit();

        $this->removeCache($doc);
        return 1;
    }

    /**
     * Proxy, Division 관련 설정이 된 Document model 반환
     *
     * @param string $instanceId document instance id
     * @return Document
     */
    public function getModel($instanceId)
    {
        $config = $this->configHandler->getOrDefault($instanceId);
        $doc = new Document;
        $doc->setDivision($config);
        $doc->setProxyOptions($this->proxyOption($config));
        return $doc;
    }

    /**
     * get document
     *
     * @param string $id document id
     * @return Document
     */
    public function get($id)
    {
        if ($this->hasCache($id) === true) {
            return $this->getCache($id);
        }

        /** @var Document $doc */
        $doc = Document::find($id);
        $doc = $this->getModel($doc->instanceId)->find($id);
        if ($doc == null) {
            throw new NotFoundDocumentException;
        }

        $this->putCache($doc);
        return $doc;
    }

    /**
     * get document by id
     *
     * @param string $id document id
     * @return DocumentEntity
     * @deprecated
     */
    public function getById($id)
    {
        if ($this->hasCache($id) === true) {
            return $this->getCache($id);
        }

        $row = $this->repo->findById($id);

        return $this->get($row['id'], $row['instanceId']);
    }

    /**
     * get document
     * Config 정보가 없기 때문에 DynamicField 관련 데이터는 없이 반환
     *
     * @param array $ids document ids
     * @return DocumentEntity
     * @deprecated
     */
    public function getsByIds(array $ids)
    {
        $rows = $this->repo->fetchByIds($ids);

        $docs = [];
        foreach ($rows as $row) {
            $docs[] = new DocumentEntity($row);
        }
        return $docs;
    }

    /**
     * get document list
     *
     * @param array $wheres make where query list
     * @param array $orders make order query list
     * @param int   $limit  number of list
     * @return DocumentEntity[]
     * @deprecated
     */
    public function gets(array $wheres, array $orders, $limit = null)
    {
        $config = null;
        if (isset($wheres['instanceId'])) {
            $config = $this->configHandler->get($wheres['instanceId']);
        }

        $docs = $this->repo->fetch($wheres, $orders, $config, $limit);
        foreach ($docs as $key => $row) {
            $docs[$key] = new DocumentEntity($row);
        }

        return $docs;
    }

    /**
     * get document list
     *
     * @param array   $wheres   make where query list
     * @param array   $orders   make order query list
     * @param int     $perPage  number of list
     * @param Closure $callback call back
     * @return LengthAwarePaginator
     * @deprecated
     */
    public function paginate(
        array $wheres,
        array $orders,
        $perPage = 10,
        Closure $callback = null
    ) {
        $config = null;
        if (isset($wheres['instanceId'])) {
            $config = $this->configHandler->get($wheres['instanceId']);
        }

        $paginator = $this->repo->paginate($wheres, $orders, $config, $perPage);
        foreach ($paginator as $key => $row) {
            $doc = new DocumentEntity($row);
            if ($callback !== null) {
                call_user_func_array($callback, [&$doc]);
            }
            $paginator[$key] = $doc;
        }

        return $paginator;
    }

    /**
     * get list count
     *
     * @param array $wheres make where query list
     * @return int
     * @deprecated
     */
    public function count(array $wheres = [])
    {
        $config = null;
        if (isset($wheres['instanceId'])) {
            $config = $this->configHandler->get($wheres['instanceId']);
        }

        return $this->repo->count($wheres, $config);
    }

    /**
     * get document count
     * 문서 수 반환
     *
     * @param string $instanceId instance id
     * @return int
     * @deprecated
     */
    public function countByInstanceId($instanceId)
    {
        return $this->repo->countByInstanceId($instanceId);
    }

    /**
     * get document list by user id
     *
     * @param string $userId  user's id
     * @param array  $wheres  make where query list
     * @param array  $orders  make order query list
     * @param array  $columns get columns list
     * @return array
     * @deprecated
     */
    public function getsByUser(
        $userId,
        array $wheres = [],
        array $orders = [],
        array $columns = ['*']
    ) {
        $wheres['userId'] = $userId;

        return $this->gets($wheres, $orders, null, $columns);
    }

    /**
     * get revision
     * 다이나믹 필드 정보 없이 가져옴
     *
     * @param string $revisionId revision id
     * @return DocumentEntity
     * @deprecated
     */
    public function getRevision($revisionId)
    {
        $doc = $this->repo->fetchRevision($revisionId);
        return new DocumentEntity($doc);
    }

    /**
     * get revision list
     *
     * @param string $id document id
     * @return array
     * @deprecated
     */
    public function getRevisions($id)
    {
        $origin = $this->repo->findById($id);
        $config = $this->configHandler->get($origin['instanceId']);

        $docs = $this->repo->getsRevision($id, $config);
        foreach ($docs as $key => $row) {
            $doc = new DocumentEntity($row);
            $docs[$key] = $doc;
        }

        return $docs;
    }

    /**
     * add memory cache
     *
     * @param Document $doc document model
     * @return void
     */
    private function putCache(Document $doc)
    {
        $this->docs[$doc->id] = $doc;
    }

    /**
     * remove memory cache
     *
     * @param Document $doc document model
     * @return void
     */
    private function removeCache(Document $doc)
    {
        if ($this->getCache($doc->id) !== null) {
            unset($this->docs[$doc->id]);
        }
    }

    /**
     * get memory cache
     *
     * @param string $id document id
     * @return DocumentEntity|null
     */
    private function getCache($id)
    {
        return $this->hasCache($id) === true ? $this->docs[$id] : null;
    }

    /**
     * has memory cache
     *
     * @param string $id document id
     * @return bool
     */
    private function hasCache($id)
    {
        return empty($this->docs[$id]) === false ? true : false;
    }
}
