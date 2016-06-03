<?php
/**
 * This file is a policy for instance class.
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Permission;

/**
 * Class InstancePolicy
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 */
class InstancePolicy extends Policy
{
    /**
     * Handle dynamic method calls into the policy.
     *
     * @param string $name      method name
     * @param array  $arguments argument for dynamic method
     * @return bool
     */
    public function __call($name, $arguments)
    {
        /**
         * @var $user
         * @var Instance $instance
         */
        list ($user, $instance) = $arguments;

        return $this->check($user, $this->get($instance->getName(), $instance->getSiteKey()), $name);
    }
}
