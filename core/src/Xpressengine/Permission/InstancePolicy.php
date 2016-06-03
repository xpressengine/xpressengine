<?php
/**
 * This file is a policy for instance class.
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Permission;

/**
 * Class InstancePolicy
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
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
