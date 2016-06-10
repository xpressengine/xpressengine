<?php
/**
 * This file is a dummy class for policy registry.
 *
 * PHP version 5
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Permission;

/**
 * Class Instance
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Instance
{
    /**
     * The key name for site
     *
     * @var string
     */
    protected $siteKey;

    /**
     * The permission name
     *
     * @var string
     */
    protected $name;

    /**
     * Instance constructor.
     *
     * @param string $name    permission name
     * @param string $siteKey site key
     */
    public function __construct($name, $siteKey = 'default')
    {
        $this->siteKey = $siteKey;
        $this->name = $name;
    }

    /**
     * Get the permission name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the site key name
     *
     * @return string
     */
    public function getSiteKey()
    {
        return $this->siteKey;
    }
}
