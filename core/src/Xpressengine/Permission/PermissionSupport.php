<?php
/**
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

use Illuminate\Http\Request;
use Xpressengine\User\Models\UserGroup;

/**
 * @category    Permission
 * @package     Xpressengine\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
trait PermissionSupport
{
    /**
     * Get permission argument
     *
     * @param string       $key       permission key
     * @param array|string $abilities abilities
     * @param string       $siteKey   site key
     * @return array
     */
    public function getPermArguments($key, $abilities, $siteKey = 'default')
    {
        $abilities = !is_array($abilities) ? [$abilities] : $abilities;

        $permission = app('xe.permission')->getOrNew($key, $siteKey);
        $mode = function ($action) use ($permission) {
            return $permission->pure($action) ? 'manual' : 'inherit';
        };
        $groups = UserGroup::get();

        $arguments = [];
        foreach ($abilities as $ability) {
            $argument = [
                'grant' => $permission[$ability],
                'title' => $ability,
                'groups' => $groups,
            ];

            if ($permission->getParent()) {
                $argument = array_merge($argument, ['mode' => $mode($ability)]);
            }

            $arguments[$ability] = $argument;
        }

        return $arguments;
    }

    /**
     * Register permission
     *
     * @param Request      $request   request instance
     * @param string       $key       permission key
     * @param array|string $abilities abilities
     * @param string       $siteKey   site key
     * @return void
     */
    public function permissionRegister(Request $request, $key, $abilities, $siteKey = 'default')
    {
        $abilities = !is_array($abilities) ? [$abilities] : $abilities;

        $grant = new Grant();
        foreach ($abilities as $ability) {
            if ($data = $this->makeGrantData($request, $ability)) {
                $grant->set($ability, $data);
            }
        }

        $this->permissionRegisterGrant($key, $grant, $siteKey);
    }

    /**
     * Register grant to permission
     *
     * @param string     $key     permission key
     * @param Grant|null $grant   grant object
     * @param string     $siteKey site key
     * @return void
     */
    public function permissionRegisterGrant($key, Grant $grant = null, $siteKey = 'default')
    {
        $grant = $grant ?: new Grant;

        app('xe.permission')->register($key, $grant, $siteKey);
    }

    /**
     * Unregister permission
     *
     * @param string $key     permission key
     * @param string $siteKey site key
     * @return void
     */
    public function permissionUnregister($key, $siteKey = 'default')
    {
        app('xe.permission')->destroy($key, $siteKey);
    }

    /**
     * Move
     *
     * @param string $from    previous key
     * @param string $to      parent key
     * @param string $siteKey site key
     * @return void
     */
    public function permissionMove($from, $to, $siteKey = 'default')
    {
        $permission = app('xe.permission')->get($from, $siteKey);
        app('xe.permission')->move($permission, $to);
    }

    /**
     * Make data for grant
     *
     * @param Request $request request instance
     * @param string  $ability ability
     * @return array|null
     */
    protected function makeGrantData(Request $request, $ability)
    {
        if ($request->get($ability . 'Mode') === 'inherit') {
            return null;
        }

        return [
            Grant::RATING_TYPE => $request->get($ability . 'Rating'),
            Grant::GROUP_TYPE => array_filter(explode(',', $request->get($ability . 'Group', ''))),
            Grant::USER_TYPE => array_filter(explode(',', $request->get($ability . 'User', ''))),
            Grant::EXCEPT_TYPE => array_filter(explode(',', $request->get($ability . 'Except', ''))),
            Grant::VGROUP_TYPE => $request->get($ability . 'VGroup', []),
        ];
    }
}
