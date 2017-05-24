<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category
 * @package     Xpressengine\
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Skins\Member;

use Xpressengine\Skin\BladeSkin;

/**
 * @category
 * @package     ${NAMESPACE}
 */
class AuthSkin extends BladeSkin
{

    protected static $id = 'user/auth/skin/xpressengine@default';

    protected static $componentInfo = [
        'name' => '기본 회원인증페이지 스킨',
        'description' => 'Xpressengine의 기본 회원인증페이지 스킨입니다'
    ];

    protected $path = 'user.skins.default.auth';

    /**
     * @inheritdoc
     */
    public function render()
    {
        $this->loadAssets();

        return parent::render();
    }

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
     * loadAssets
     *
     * @return void
     */
    protected function loadAssets()
    {
        app('xe.frontend')->css(
            [
                'assets/core/xe-ui-component/xe-ui-component.css',
                'assets/core/member/auth.css'
            ]
        )->load();
    }
}
