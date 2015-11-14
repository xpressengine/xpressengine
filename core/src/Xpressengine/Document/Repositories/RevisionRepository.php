<?php
/**
 * RevisionRepository
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
namespace Xpressengine\Document\Repositories;

use Xpressengine\Database\VirtualConnectionInterface;
use Xpressengine\Keygen\Keygen;
use Xpressengine\DynamicField\RevisionManager;
use Xpressengine\Config\ConfigEntity;
use Xpressengine\Document\DocumentEntity;

/**
 * RevisionRepository
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class RevisionRepository
{
    protected $table = 'documents_revision';

    /**
     * @var VirtualConnectionInterface
     */
    protected $connection;

    /**
     * @var RevisionManager
     */
    protected $revisionManager;

    /**
     * @var Keygen
     */
    protected $keygen;

    /**
     * 여기에 지정된 column 왜에 다른 column 이 수정되면 revision insert
     *
     * @var array
     */
    protected $exceptColumns = [
        'readCount',
        'commentCount',
        'assentCount',
        'dissentCount',
        'updatedAt',
    ];

    /**
     * @param VirtualConnectionInterface $connection      database connection
     * @param RevisionManager            $revisionManager dynamic field revision manager
     * @param Keygen                     $keygen          key generator
     */
    public function __construct(
        VirtualConnectionInterface $connection,
        RevisionManager $revisionManager,
        Keygen $keygen
    ) {
        $this->connection = $connection;
        $this->revisionManager = $revisionManager;
        $this->keygen = $keygen;
    }

    /**
     * set $columnList
     *
     * @param array $columns set columnList
     * @return void
     */
    public function setExceptColumns(array $columns)
    {
        $this->exceptColumns = $columns;
    }

    /**
     * add column to $columnList
     *
     * @param string $name column name of exceptColumns
     * @return void
     */
    public function addExceptColumn($name)
    {
        $this->exceptColumns[] = $name;
    }

    /**
     * update시 revision data를 insert해야 할지 체크 한다.
     *
     * @param DocumentEntity $doc document entity
     * @return bool
     */
    public function isChanged(DocumentEntity $doc)
    {
        if (array_diff(array_keys($doc->diff()), $this->exceptColumns)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * get next revision no by document id
     *
     * @param string $id document id
     * @return int
     */
    public function nextNo($id)
    {
        $revisionNo = $this->connection->table($this->table)
            ->where('id', $id)->max('revisionNo');
        if ($revisionNo === null) {
            $revisionNo = 0;
        }
        return ++$revisionNo;
    }

    /**
     * insert new document revision
     *
     * @param DocumentEntity $doc    inserted document entity
     * @param ConfigEntity   $config document config entity
     * @return DocumentEntity
     */
    public function insert(DocumentEntity $doc, ConfigEntity $config)
    {
        $doc->revisionId = $this->keygen->generate();
        $doc->revisionNo = $this->nextNo($doc->id);
        $this->connection->dynamic($this->table)->insert($doc->getAttributes());

        $configs = $this->revisionManager->getHandler()->getConfigHandler()->gets($config->get('group'));
        $this->revisionManager->add($configs, $doc->getAttributes());

        return $doc;
    }


    /**
     * get inserted revision data by revision $id
     *
     * @param string $revisionId revision id
     * @return array
     */
    public function find($revisionId)
    {
        $query = $this->connection->table($this->table)->where('revisionId', $revisionId);
        return $query->first();
    }

    /**
     * get inserted revision data list by document id
     *
     * @param string       $id     document id
     * @param ConfigEntity $config document config entity
     * @return array
     */
    public function fetchById($id, ConfigEntity $config)
    {
        $query = $this->connection->table($this->table)->where('id', $id);

        $configs = $this->revisionManager->getHandler()->getConfigHandler()->gets($config->get('group'));
        $query = $this->revisionManager->join($configs, $query->getQuery());

        return $query->orderBy($this->table . '.revisionNo', 'desc')->get([
            '*',
            'documents_revision.revisionId as revisionId',
            'documents_revision.revisionNo as revisionNo'
        ]);
    }

    /**
     * delete revisions data by instance id
     *
     * @param string $instanceId instance id
     * @return int
     */
    public function deleteByInstanceId($instanceId)
    {
        return $this->connection->table($this->table)
            ->where('instanceId', $instanceId)->delete();
    }

    /**
     * delete revision by document revision id
     *
     * @param DocumentEntity $doc document entity
     * @return void
     */
    public function delete(DocumentEntity $doc)
    {
        $this->connection->table($this->table)->where('revisionId', $doc->revisionId)->delete();
    }

    /**
     * delete revision by document id
     *
     * @param string $id document id
     * @return void
     */
    public function deleteByDocumentId($id)
    {
        $this->connection->table($this->table)
            ->where('id', $id)->delete();
    }
}
