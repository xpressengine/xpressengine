<?php
/**
 * This file is abstract media handler
 *
 * PHP version 5
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Media\Handlers;

use Xpressengine\Media\Models\Media;
use Xpressengine\Media\Repositories\MediaRepository;
use Xpressengine\Storage\File;

/**
 * Abstract class AbstractHandler
 *
 * @category    Media
 * @package     Xpressengine\Media
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
abstract class AbstractHandler implements MediaHandler
{
    /**
     * MediaRepository instance
     *
     * @var MediaRepository
     */
    protected $repo;

    /**
     * AbstractHandler constructor.
     *
     * @param MediaRepository $repo MediaRepository instance
     */
    public function __construct(MediaRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * 각 미디어 타입에서 사용가능한 확장자 인지 판별
     *
     * @param string $mime mime type
     * @return bool
     */
    public function isAvailable($mime)
    {
        return in_array($mime, $this->getAvailableMimes());
    }

    /**
     * 각 미디어 타입에서 사용가능한 확장자 반환
     *
     * @return array
     */
    public function getAvailableMimes()
    {
        $class = $this->repo->getModel();

        return $class::getMimes();
    }

    /**
     * Make model
     *
     * @param File $file file instance
     * @return Media
     */
    public function makeModel(File $file)
    {
        $class = $this->repo->getModel();

        return $class::make($file);
    }

    /**
     * __call
     *
     * @param string $name      method name
     * @param array  $arguments arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->repo, $name], $arguments);
    }
}
