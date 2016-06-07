<?php
namespace Xpressengine\Permission;

use Illuminate\Http\Request;
use Xpressengine\User\Models\UserGroup;

trait PermissionSupport
{
    public function getPermArguments($key, $abilities)
    {
        $abilities = !is_array($abilities) ? [$abilities] : $abilities;

        $permission = app('xe.permission')->findOrNew($key);
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

    public function permissionRegister(Request $request, $key, $abilities)
    {
        $abilities = !is_array($abilities) ? [$abilities] : $abilities;

        $grant = new Grant();
        foreach ($abilities as $ability) {
            if ($data = $this->makeGrantData($request, $ability)) {
                $grant->set($ability, $data);
            }
        }

        app('xe.permission')->register($key, $grant);
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
