<?php namespace Xpressengine\UIObjects\Permission;

use Frontend;
use Xpressengine\UIObject\AbstractUIObject;

/**
 * Class Permission
 *
 * @package Xpressengine\UIObjects\Permission
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
        Frontend::js('/assets/vendor/core/lodash.min.js')->appendTo('head')->load();
        Frontend::js('/assets/vendor/permission/PermissionTag.js')->type('text/jsx')->appendTo('head')->load();
        Frontend::js('/assets/vendor/permission/PermissionTagSuggestion.js')->type('text/jsx')->appendTo('head')->load(
        );
        Frontend::js('/assets/vendor/permission/PermissionInclude.js')->type('text/jsx')->appendTo('head')->load();
        Frontend::js('/assets/vendor/permission/PermissionExclude.js')->type('text/jsx')->appendTo('head')->load();
        Frontend::js('/assets/vendor/permission/Permission.js')->type('text/jsx')->appendTo('head')->load();
        Frontend::css('/assets/vendor/permission/permission.css')->load();

        $permissioinScriptString = [];

        $permissioinScriptString[] = "<script type='text/jsx'>";
        $permissioinScriptString[] = "$('.__xe__uiobject_permission').each(function(i) {";
        $permissioinScriptString[] = "var el = $(this),";
        $permissioinScriptString[] = "data = el.data('data');";
        $permissioinScriptString[] = "key= el.data('key');";
        $permissioinScriptString[] = "type = el.data('type');";
        $permissioinScriptString[] = "memberUrl = el.data('memberUrl');";
        $permissioinScriptString[] = "groupUrl= el.data('groupUrl');";
        $permissioinScriptString[] = "vgroupAll= el.data('vgroupAll');";
        $permissioinScriptString[] = "React.render(<Permission ";
        $permissioinScriptString[] = "
                                    key={key}
                                    memberSearchUrl={memberUrl}
                                    groupSearchUrl={groupUrl}
                                    permission={data}
                                    type={type}
                                    vgroupAll={vgroupAll}
                                    />";

        $permissioinScriptString[] = ", this);\n";
        $permissioinScriptString[] = "});";
        $permissioinScriptString[] = "</script>";

        $permissioinScriptString = implode('', $permissioinScriptString);

        Frontend::html('permissionUiobject')->content($permissioinScriptString)->load();

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
        $memberRepo = app('xe.users');

        $groups = array_map(
            function($group) {
                return array_only($group->toArray(), ['id','name']);
            },
            $groupRepo->find($grant['group'])->toArray()
        );
        $users = array_map(
            function($user) {
                return array_only($user->toArray(), ['id','displayName']);
            },
            $memberRepo->find($grant['user'])->toArray()
        );

        $excepts = array_map(
            function($except) {
                return array_only($except->toArray(), ['id','displayName']);
            },
            $memberRepo->find($grant['except'])->toArray()
        );

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

        $memberSearchUrl = route('settings.member.search');
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
