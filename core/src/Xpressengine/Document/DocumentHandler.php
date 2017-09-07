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
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Database\DynamicQuery;
use Xpressengine\Database\VirtualConnectionInterface as VirtualConnection;
use Xpressengine\Document\Exceptions\DocumentNotFoundException;
use Xpressengine\Document\Models\Document;
use Xpressengine\Document\Models\Revision;

/**
 * DocumentHandler
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
        Document::where('instance_id', $config->get('instanceId'))->chunk(
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
        $doc->setProxyOptions($this->proxyOption($this->getConfig($attributes['instance_id'])));
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

        $doc->pure_content = $doc->getPureContent($doc->content);
        if ($doc->ipaddress == '') {
            $doc->ipaddress = $this->request->ip();
        }
        $doc->checkRequired($doc->getAttributes());
        $doc->setProxyOptions($this->proxyOption($this->getConfig($doc->instance_id)));
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
        $instanceId = $doc->instance_id;
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
        $lastRevision = $this->newRevisionModel()->where('id', $doc->id)->max('revision_no');
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
     * pivot Division Table
     *
     * @param Document     $doc    document entity
     * @param ConfigEntity $config config entity
     *
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
        $instanceId = $doc->instance_id;
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
        $params['certify_key'] = $doc->certify_key !== null ? $doc->certify_key : '';
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
        $instanceId = $doc->instance_id;

        // 인스턴스를 변경할 경우 이전의 division 테이블 row 삭제
        if ($instanceId != $doc->getOriginal('instance_id')) {
            $originConfig = $this->configHandler->getOrDefault($doc->getOriginal('instance_id'));
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
        if ($instanceId != $doc->getOriginal('instance_id')) {
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
        $instanceId = $doc->instance_id;
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
        $doc->setProxyOptions($this->proxyOption($this->getConfig($doc->instance_id)));
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
            $model->where('instance_id', '=', $instanceId);
        }
        $doc = $model->where('id', '=', $id)->first();
        if ($doc == null) {
            throw new DocumentNotFoundException;
        }
        return $doc;
    }
}
