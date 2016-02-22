<?php namespace Xpressengine\UIObjects\Settings;

use Xpressengine\Permission\Factory;
use Xpressengine\Permission\Grant;
use Xpressengine\Permission\Permission;
use Xpressengine\UIObject\AbstractUIObject;

class SettingsPermission extends AbstractUIObject
{
    protected static $id = 'uiobject/xpressengine@registeredPermission';
    protected $maxShowItemDepth;

    public function render()
    {
        $htmlString = [];
        $args = $this->arguments;

        $title = $args['title'];
        $type = $args['type'];
        $target = $args['target'];

        /** @var Factory $permissionFactory */
        $permissionFactory = app('xe.permission');
        $permission = $permissionFactory->make($type, $target);
        $actions = $permission->getActions();
        $registered = $permission->getRegistered();

        $groups = app('xe.member.groups')->all();

        $settings = [];
        $content = [];
        foreach ($actions as $action) {
            $pureGrant = $registered->pure($action);
            $mode = "manual";

            $content[] = uio('permission', [
                'mode' => $mode,
                'title' => $action,
                'grant' => $this->getGrant($registered, $action),
                'groups' => $groups
            ])->render();
        }
        $content = implode('<hr>', $content);
        $settings[] = $this->generateBox($title, $content);
        $this->template = implode(PHP_EOL, $settings);

        return parent::render();
    }

    public static function boot()
    {
        // TODO: Implement boot() method.
    }

    public static function getSettingsURI()
    {
    }

    protected function getGrant(Permission $registered, $action)
    {
        $defaultPerm = [
            Grant::RATING_TYPE => '',
            Grant::GROUP_TYPE => [],
            Grant::USER_TYPE => [],
            Grant::EXCEPT_TYPE => []
        ];

        if ($registered[$action] != null) {
            $grant = array_merge($defaultPerm, $registered[$action]);
        } else {
            $grant = $defaultPerm;
        }

        return $grant;
    }

    private function generateBox($title, $content)
    {
        return "<div class=\"form-group\">
    <label>$title</label>
    <div class=\"well\">
        $content
    </div>
</div>";
    }
}
