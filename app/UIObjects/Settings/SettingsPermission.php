<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Settings;

use XeFrontend;
use Xpressengine\Permission\Grant;
use Xpressengine\Permission\Permission;
use Xpressengine\Permission\PermissionHandler;
use Xpressengine\UIObject\AbstractUIObject;

class SettingsPermission extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@registeredPermission';
    protected $maxShowItemDepth;

    public function render()
    {
        $args = $this->arguments;

        $permissionInfo = $args['permission'];
        $title = $permissionInfo['title'];

        /** @var Permission $permission */
        $permission = $permissionInfo['permission'];

        // permission is collection of grant
        // grant is bundle of assigned
        // $grant = [
        //    'rating' => $visibleGrant['rating'],
        //    'group' => UserGroup::whereIn('id', $visibleGrant['group'])->get()->toArray(),
        //    'user' => User::whereIn('id', $visibleGrant['user'])->get()->toArray(),
        //    'except' => User::whereIn('id', $visibleGrant['except'])->get()->toArray(),
        // ];

        $groups = app('xe.user.groups')->all();

        $settings = [];
        $content = uio('permission', [
            'mode' => 'manual',
            'title' => 'access',
            'grant' => $this->getGrant($permission['access']),
            'groups' => $groups
        ]);
        $settings[] = $this->generateBox($title, $content);
        $this->template = implode(PHP_EOL, $settings);

//        XeFrontend::js('/assets/core/permission/Permission.js')->unload();

//        XeFrontend::js([
//
//            '/assets/core/permission/SettingsPermission.js',
//            '/assets/core/permission/PermissionTag.js'
//
//        ])->load();

        return parent::render();
    }

    protected function getGrant($grant)
    {
        $defaultGrant = [
            Grant::RATING_TYPE => '',
            Grant::GROUP_TYPE => [],
            Grant::USER_TYPE => [],
            Grant::EXCEPT_TYPE => []
        ];

        if ($grant !== null) {
            return array_merge($defaultGrant, $grant);
        } else {
            return $defaultGrant;
        }
    }

    private function generateBox($title, $content)
    {
        return "<div class=\"form-group\">
        $content
</div>";
    }
}
