<?php
namespace Xpressengine\Permission;

use Illuminate\Http\Request;
use Xpressengine\User\Models\UserGroup;

trait PermissionSupport
{
    public function getPermArguments($key, $abilities, $siteKey = 'default')
    {
        $abilities = !is_array($abilities) ? [$abilities] : $abilities;

        $permission = app('xe.permission')->findOrNew($key, $siteKey);
        $mode = function ($action) use ($permission) {
            return $permission->pure($action) ? 'manual' : 'inherit';
        };
        $groups = UserGroup::get();

        $arguments = [];
        foreach ($abilities as $ability) {
            $arguments[$ability] = [
                'mode' => $mode($ability),
                'grant' => $permission[$ability],
                'title' => $ability,
                'groups' => $groups,
            ];
        }
        
        return $arguments;
    }

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

    public function permissionRegisterGrant($key, Grant $grant = null, $siteKey = 'default')
    {
        $grant = $grant ?: new Grant;

        app('xe.permission')->register($key, $grant, $siteKey);
    }

    public function permissionUnregister($key, $siteKey = 'default')
    {
        app('xe.permission')->destroy($key, $siteKey);
    }

    public function permissionMove($from, $to, $siteKey = 'default')
    {
        $permission = app('xe.permission')->find($from, $siteKey);
        app('xe.permission')->move($permission, $to);
    }

    protected function makeGrantData(Request $request, $ability)
    {
        if ($request->get($ability . 'Mode') === 'inherit') {
            return null;
        }

        return [
            Grant::RATING_TYPE => $request->get($ability . 'Rating'),
            Grant::GROUP_TYPE => $request->get($ability . 'Group', []),
            Grant::USER_TYPE => array_filter(explode(',', $request->get($ability . 'User', ''))),
            Grant::EXCEPT_TYPE => array_filter(explode(',', $request->get($ability . 'Except', ''))),
            Grant::VGROUP_TYPE => $request->get($ability . 'VGroup', []),
        ];
    }
}
