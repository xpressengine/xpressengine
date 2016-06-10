<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Support;

/**
 * Interface Migration
 *
 * @category    Support
 * @package     Xpressengine\Support
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
    public function checkInstalled();

    /**
     * install
     *
     * @return mixed
     */
    public function install();

    /**
     * checkUpdate
     *
     * @param string $installedVersion current version
     *
     * @return mixed
     */
    public function checkUpdated($installedVersion = null);

    /**
     * update
     *
     * @param string $installedVersion current version
     *
     * @return mixed
     */
    public function update($installedVersion = null);
}
