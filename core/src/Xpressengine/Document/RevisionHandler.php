<?php
/**
 * RevisionHandler
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

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Document\Model\Document;
use Xpressengine\Document\Model\Revision;
use Xpressengine\DynamicField\RevisionManager;

/**
 * RevisionHandler
 *
 * @category    Document
 * @package     Xpressengine\Document
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class RevisionHandler
{

    /**
     * @var ConfigHandler
     */
    protected $configHandler;

    /**
     * @var RevisionManager
     */
    protected $revisionManager;

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
     * RevisionHandler constructor.
     *
     * @param ConfigHandler $configHandler
     * @param RevisionManager $revisionManager
     */
    public function __construct(ConfigHandler $configHandler, RevisionManager $revisionManager)
    {
        $this->configHandler = $configHandler;
        $this->revisionManager = $revisionManager;
    }

    /**
     * Add revision
     *
     * @param array $attributes document attributes
     * @return Revision
     */
    public function add(array $attributes)
    {
        $config = $this->configHandler->getOrDefault($attributes['instanceId']);

        if ($config->get('revision') === true && $this->isChanged($attributes) === true) {
            $revision = new Revision($attributes);
            $revision->revisionId = $revision->getKeyGenerator()->generate();
            $revision->revisionNo = $this->nextNo($revision->revisionId);
        }
    }


    /**
     * update 할 때 Document 가 변경되었는지 확인
     *
     * @param array $attributes document attributes
     * @return bool
     */
    public function isChanged(array $attributes)
    {
        /** @var Document $current */
        $current = Document::find($attributes['id']);

        if (array_diff(
            array_keys(array_diff_assoc($attributes, $current->toArray())), $this->exceptColumns
        )) {
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
        $revisionNo = Revision::where('id', $id)->max('revisionNo');
        if ($revisionNo === null) {
            $revisionNo = 0;
        }
        return ++$revisionNo;
    }

    public function getModel($instanceId)
    {
        $config = $this->configHandler->getOrDefault($instanceId);
        $revision = new Revision;
        $revision->setProxyOptions($this->proxyOption($config));
        return $revision;
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
            $options['revision'] = true;
        }

        return $options;
    }
}
