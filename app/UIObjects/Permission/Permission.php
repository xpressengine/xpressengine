<?php
/**
 * Permission.php
 *
 * PHP version 7
 *
 * @category    UIObjects
 * @package     App\UIObjects\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Permission;

use XeFrontend;
use Xpressengine\UIObject\AbstractUIObject;

/**
 * Class Permission
 *
 * @category    UIObjects
 * @package     App\UIObjects\Permission
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Permission extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@permission';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        XeFrontend::js('/assets/core/permission/permission.bundle.js')->load();
        XeFrontend::css('/assets/core/permission/permission.css')->load();
        XeFrontend::translation([
            'xe::inheritMode', 'xe::userRatingAdministrator', 'xe::userRatingManager',
            'xe::user', 'xe::guest', 'xe::userRating', 'xe::includeUserOrGroup', 'xe::excludeUser',
            'xe::includeVGroup', 'xe::explainIncludeUserOrGroup', 'xe::explainExcludeUser'
        ]);

        $htmlString = [];
        $args = $this->arguments;

        $grant = $args['grant'];
        $title = $args['title'];
        $inheritMode = isset($args['mode']) ? $args['mode'] : null;

        $permissionJsonString = $this->getPermissionJsonString($grant, $inheritMode);
        $htmlString[] = $this->loadHtmlString($title, $permissionJsonString);

        $this->template = implode('', $htmlString);

        return parent::render();
    }

    /**
     * Convert the permission to json string.
     *
     * @param array       $grant       grant
     * @param string|null $inheritMode use inherit
     * @return string
     */
    protected function getPermissionJsonString($grant, $inheritMode)
    {
        $permissionValueArray = [];

        if ($inheritMode !== null) {
            $permissionValueArray['mode'] = $inheritMode;
        }

        $groupRepo = app('xe.user.groups');
        $userRepo = app('xe.users');

        $groups = $groupRepo->findMany($grant['group']);
        $users = $userRepo->findMany($grant['user'], ['id','display_name']);
        $excepts = $userRepo->findMany($grant['except'], ['id','display_name']);

        $permissionValueArray['rating'] = $grant['rating'];
        $permissionValueArray['group'] = $groups;
        $permissionValueArray['user'] = $users;
        $permissionValueArray['except'] = $excepts;
        $permissionValueArray['vgroup'] = isset($grant['vgroup']) ? $grant['vgroup'] : [];

        return json_encode($permissionValueArray);
    }

    /**
     * Load html by given data.
     *
     * @param string $title   title
     * @param string $jsonRet json type string
     * @return string
     */
    protected function loadHtmlString($title, $jsonRet)
    {

        $userSearchUrl = route('settings.user.search');
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
                    data-key='{$uibojectKey}' data-user-url='{$userSearchUrl}' data-group-url='{$groupSearchUrl}'
                    data-type='{$title}' data-vgroup-all='{$jsonVGroups}'></div>";


        return implode('', $htmlString);
    }
}
