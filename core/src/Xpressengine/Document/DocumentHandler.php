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
        $documentConfig = $this->configHandler->make($instanceId, $params);
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
        $model = new Document;

        $model->getConnection()->beginTransaction();

        $attributes = $model->fixedAttributes($attributes);

        if (empty($attributes['ipaddress']) === true) {
            $attributes['ipaddress'] = $this->request->ip();
        }

        $model->checkRequired($attributes);

        $config = $this->configHandler->getOrDefault($attributes['instanceId']);

        $model->setProxyOptions($this->proxyOption($config));
        //$model->dynamicFill($attributes);
        // insert to original documents database table
        $model = $model->create($attributes);

        // insert to division documents database table
        if ($config->get('division') == true) {
            $divisionDoc = new Document;
            $divisionDoc->setDivision($config)->create($model->toArray());
        }

        // insert to revision database table
        $revisionDoc = new Revision;
        $revisionDoc->create($model->toArray());

        $model->getConnection()->commit();

        return $model;
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
     * @return bool
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
        $result = $doc->delete();

        $this->conn->commit();

        return $result;
    }

    /**
     * Proxy, Division 관련 설정이 된 Document model 반환
     *
     * @param string $instanceId document instance id
     * @return Document
     */
    public function getModel($instanceId = null)
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
