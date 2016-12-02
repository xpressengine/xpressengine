<?php
/**
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Permission;

use XeFrontend;
use Xpressengine\UIObject\AbstractUIObject;

/**
 * Class Permission
 *
 * @package App\UIObjects\Permission
 */
class Permission extends AbstractUIObject
{
    /**
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@permission';
    /**
     * @var
     */
    protected $maxShowItemDepth;

    /**
     * render
     *
     * @return string
     */
    public function render()
    {
        XeFrontend::js('/assets/vendor/lodash/lodash.min.js')->load();
        XeFrontend::js([
//            '/assets/vendor/vendor.bundle.js',
            '/assets/core/permission/permission.bundle.js'
        ])->load();

        XeFrontend::css('/assets/core/permission/permission.css')->load();

        XeFrontend::translation([
            'xe::inheritMode', 'xe::memberRatingAdministrator', 'xe::memberRatingManager',
            'xe::member', 'xe::guest', 'xe::memberRating', 'xe::includeUserOrGroup', 'xe::excludeUser',
            'xe::includeVGroup', 'xe::explainIncludeUserOrGroup', 'xe::explainExcludeUser'
        ]);

        $htmlString = [];
        $args = $this->arguments;

        $inheritMode = null;

        $grant = $args['grant'];
         $title = $args['title'];
        if (isset($args['mode'])) {
            $inheritMode = $args['mode'];
        }

        $permissionJsonString = $this->getPermissionJsonString($grant, $inheritMode);
        $htmlString[] = $this->loadReactComponent($title.'xe_permission', $title, $permissionJsonString);

        $this->template = implode('', $htmlString);

        return parent::render();
    }

    /**
     * boot
     *
     * @return void
     */
    public static function boot()
    {
        // TODO: Implement boot() method.
    }

    /**
     * getSettingsURI
     *
     * @return void
     */
    public static function getSettingsURI()
    {
    }

    protected function getPermissionJsonString($grant, $inheritMode)
    {
        $permissionValueArray = [];

        if ($inheritMode !== null) {
            $permissionValueArray['mode'] = $inheritMode;
        }

        $groupRepo = app('xe.user.groups');
        $userRepo = app('xe.users');

        $groups = $groupRepo->findMany($grant['group']);
        $users = $userRepo->findMany($grant['user'], ['id','displayName']);
        $excepts = $userRepo->findMany($grant['except'], ['id','displayName']);

        $permissionValueArray['rating'] = $grant['rating'];
        $permissionValueArray['group'] = $groups;
        $permissionValueArray['user'] = $users;
        $permissionValueArray['except'] = $excepts;
        $permissionValueArray['vgroup'] = isset($grant['vgroup']) ? $grant['vgroup'] : [];

        return json_encode($permissionValueArray);
    }

    protected function permissionScript()
    {
    }

    protected function loadReactComponent($container, $title, $jsonRet)
    {

        $memberSearchUrl = route('settings.user.search');
        $groupSearchUrl = route('manage.group.search');
        $vgroupAll = app('xe.user.virtualGroups')->all();

        $uibojectKey = "__xe__permission_{$title}_uiobject_data";

        $container = '__xe__uiobject_permission';

        $vgroups = [];
        foreach ($vgroupAll as $vgroup) {
            $vgroups[] = $vgroup->toArray();
        }
        $jsonVGroups = json_enc($vgroups);
        $htmlString = [];
        $htmlString[] = "<div class='{$container}' data-data='{$jsonRet}' data-title='{$title}'
                    data-key='{$uibojectKey}' data-member-url='{$memberSearchUrl}' data-group-url='{$groupSearchUrl}'
                    data-type='{$title}' data-vgroup-all='{$jsonVGroups}'></div>";


        return implode('', $htmlString);
    }
}
