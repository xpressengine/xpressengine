<?php
/**
 * This file is a policy for instance class.
 *
 * PHP version 7
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Permission;

/**
 * Class InstancePolicy
 *
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
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
