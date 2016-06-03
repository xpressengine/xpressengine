<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * @category
 * @package     Xpressengine\
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Skins\Member;

use Xpressengine\Plugin\PluginHandler;
use Xpressengine\Skin\BladeSkin;

/**
 * @category
 * @package     ${NAMESPACE}
 */
class AuthSkin extends BladeSkin
{

    protected static $id = 'member/auth/skin/xpressengine@default';

    protected static $componentInfo = [
        'name' => '기본 회원인증페이지 스킨',
        'description' => 'Xpressengine의 기본 회원인증페이지 스킨입니다'
    ];

    protected $path = 'member.skins.default.auth';

    /**
     * @inheritdoc
     */
    public function render()
    {
        $this->loadAssets();

        return parent::render();
    }

    /**
     * loadAssets
     *
     * @return void
     */
    protected function loadAssets()
    {
        \XeFrontend::css(
            [
                'assets/core/xe-ui-component/xe-ui-component.css',
                'assets/core/member/auth.css'
            ]
        )->load();

        // \XeFrontend::js('assets/vendor/bootstrap/js/bootstrap.js')
        //     ->min('assets/vendor/bootstrap/js/bootstrap.min.js')
        //     ->appendTo('head')
        //     ->load();
    }
}
