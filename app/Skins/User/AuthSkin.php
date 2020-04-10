<?php
/**
 * AuthSkin.php
 *
 * PHP version 7
 *
 * @category    Skins
 * @package     App\Skins\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Skins\User;

use Xpressengine\Skin\GenericSkin;

/**
 * Class AuthSkin
 *
 * @category    Skins
 * @package     App\Skins\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class AuthSkin extends GenericSkin
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'user/auth/skin/xpressengine@default';

    /**
     * The information for the component
     *
     * @var array
     */
    protected static $componentInfo = [
        'name' => '기본 회원인증페이지 스킨',
        'description' => 'Xpressengine의 기본 회원인증페이지 스킨입니다'
    ];

    /**
     * @var string
     */
    protected static $path = 'user.skins.default.auth';

    /**
     * @var array
     */
    protected static $info = [];

    /**
     * @var string
     */
    protected static $viewDir = '';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $this->loadAssets();

        return parent::render();
    }

    /**
     * Show the confirm view for register.
     *
     * @return \Illuminate\View\View
     */
    protected function registerIndex()
    {
        app('xe.frontend')->js(
            [
                'assets/core/xe-ui-component/js/xe-page.js',
                'assets/core/xe-ui-component/js/xe-form.js'
            ]
        )->load();
        return $this->renderBlade('register.index');
    }

    /**
     * Show the view for register.
     *
     * @return \Illuminate\View\View
     */
    protected function registerCreate()
    {
        app('xe.frontend')->js(
            [
                'assets/core/xe-ui-component/js/xe-page.js',
                'assets/core/xe-ui-component/js/xe-form.js'
            ]
        )->load();
        return $this->renderBlade('register.create');
    }

    /**
     * Load assets.
     *
     * @return void
     */
    protected function loadAssets()
    {
        app('xe.frontend')->css(
            [
                'assets/core/xe-ui-component/xe-ui-component.css',
                'assets/core/user/auth.css'
            ]
        )->load();
    }
}
