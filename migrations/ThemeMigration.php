<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Migrations;

use XeLang;
use Xpressengine\Support\Migration;

class ThemeMigration extends Migration
{
    public function installed()
    {
        // init config
        \DB::table('config')->insert(
            [
                ['name' => 'theme', 'vars' => '[]'],
                ['name' => 'theme.settings', 'vars' => '[]'],
                ['name' => 'theme.settings.theme/alice@alice', 'vars' => '[]']
            ]
        );
    }

    public function initialized()
    {
        // set site default theme
        $theme = ['desktop' => 'theme/alice@alice.0', 'mobile' => 'theme/alice@alice.0'];
        app('xe.theme')->setSiteTheme($theme);

        // set alice theme
        $this->setAliceTheme();
    }

    public function setAliceTheme()
    {
        $multiLines = [
            'slide1Title' => ['ko'=>'EVERYTHING'.PHP_EOL.'YOU NEED', 'en'=>'EVERYTHING'.PHP_EOL.'YOU NEED'],
            'slide1Subtitle' => ['ko'=>'당신이 원하는 모든 기능이 이미 준비되어 있습니다.', 'en'=>'All the features you want are already prepared.'],
            'slide2Title' => ['ko'=>'An experience '.PHP_EOL.'unlike any other.', 'en'=>'An experience '.PHP_EOL.'unlike any other.'],
            'slide2Subtitle' => ['ko'=>'모든 사용자에게 특별한 경험을 제공합니다.', 'en'=>'To all users, providing a special experience.'],
            'slide3Title' => ['ko'=>'Sharing, '.PHP_EOL.'Publishing &amp; Pleasure.', 'en'=>'Sharing, '.PHP_EOL.'Publishing &amp; Pleasure.'],
            'slide3Subtitle' => ['ko'=>'지식을 나누고 컨텐츠를 출판하며 즐거움을 함께합니다.', 'en'=>'Publishing content to share knowledge and with pleasure.'],
            'footerContents' => ['ko'=>'We made what you need.<br>by XpressEngine', 'en'=>'We made what you need.<br>by XpressEngine'],
        ];
        foreach($multiLines as $key => $lang) {
            $langKey = XeLang::genUserKey();
            XeLang::save($langKey, 'ko', $lang['ko'], true);
            $multiLines[$key] = $langKey;
        }

        $singleLines = [
            'logoText' => ['ko'=>'Alice', 'en'=>'Alice'],
            'footerLogoText' => ['ko'=>'<i class="xi-xpressengine"></i>', 'en'=>'<i class="xi-xpressengine"></i>'],
        ];
        foreach($singleLines as $key => $lang) {
            $langKey = XeLang::genUserKey();
            XeLang::save($langKey, 'ko', $lang['ko'], false);
            $singleLines[$key] = $langKey;
        }

        // for sub(기본)
        $default = [
            '_configId' => 'theme/alice@alice.0',
            '_configTitle' => '기본',
            'colorset' => '',
            'contentAreaType' => 'xe-container',
            'layout' => 'sub',
            'slide1Image' => ['path' => 'plugins/alice/theme/assets/img/img_slide.jpg'],
            'slide2Image' => ['path' => 'plugins/alice/theme/assets/img/img_slide2.jpg'],
            'slide3Image' => ['path' => 'plugins/alice/theme/assets/img/img_slide3.jpg'],
            'logoImage' => ['path' => null],
            'headerPosition' => '',
            'headerColorset' => 'black-header',
            'footerLogoImage' => ['path'=>null],
            'useFooterLinks' => 'N',
            'footerLinkIcon' => [],
            'footerLinkUrl' => [],
            'useMultiLang' => 'Y'
        ];

        app('xe.theme')->setThemeConfig('theme/alice@alice.0', array_merge($default, $multiLines, $singleLines));

        // for main
        $main = [
            '_configId' => 'theme/alice@alice.1',
            '_configTitle' => '메인페이지용',
            'colorset' => '',
            'contentAreaType' => 'xe-container-fluid',
            'layout' => 'main',
            'slide1Image' => ['path' => 'plugins/alice/theme/assets/img/img_slide.jpg'],
            'slide2Image' => ['path' => 'plugins/alice/theme/assets/img/img_slide2.jpg'],
            'slide3Image' => ['path' => 'plugins/alice/theme/assets/img/img_slide3.jpg'],
            'logoImage' => ['path' => null],
            'headerPosition' => '',
            'headerColorset' => '',
            'footerLogoImage' => ['path'=>null],
            'useFooterLinks' => 'N',
            'footerLinkIcon' => [],
            'footerLinkUrl' => [],
        ];

        app('xe.theme')->setThemeConfig('theme/alice@alice.1', array_merge($default, $main, $multiLines, $singleLines));
    }
}
