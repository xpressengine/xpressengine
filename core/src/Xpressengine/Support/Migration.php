<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
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
