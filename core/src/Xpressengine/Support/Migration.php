<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

namespace Xpressengine\Support;

/**
 * Interface Migration
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 * @property string id
 * @property string title
 * @property string parentId
 */
interface Migration
{
    /**
     * checkInstall
     *
     * @return mixed
     */
    public function checkInstall();

    /**
     * install
     *
     * @return mixed
     */
    public function install();

    /**
     * checkUpdate
     *
     * @param string $currentVersion current version
     *
     * @return mixed
     */
    public function checkUpdate($currentVersion);

    /**
     * update
     *
     * @param string $currentVersion current version
     *
     * @return mixed
     */
    public function update($currentVersion);
}
