<?php
namespace Xpressengine\Migrations;

use XeLang;
use Xpressengine\Support\Migration;

class ThemeMigration implements Migration
{

    public function install()
    {
    }

    public function installed()
    {
        // init config
        \DB::table('config')->insert(
            [
                ['name' => 'theme', 'vars' => '[]'],
                ['name' => 'theme.settings', 'vars' => '[]']
            ]
        );
    }

    public function init()
    {
        // set site default theme
        $theme = ['desktop' => 'theme/alice@sub', 'mobile' => 'theme/alice@sub'];
        app('xe.theme')->setSiteTheme($theme);

        // set alice theme
        $this->setAliceTheme();
    }

    protected function setAliceTheme()
    {
        // for sub(기본)
        $default = [
            '_configId' => 'theme/alice@alice',
            '_configTitle' => '기본',
            'colorset' => '',
            'contentAreaType' => 'xe-container',
            'layout' => 'sub',
            'slide1Image' => ['path' => 'plugins/alice/theme/assets/img/img_slide.jpg'],
            'slide1Title' => 'EVERYTHING<br>YOU NEED',
            'slide1Subtitle' => '당신이 원하는 모든 기능이 이미 준비되어 있습니다.',
            'slide2Image' => ['path' => 'plugins/alice/theme/assets/img/img_slide2.jpg'],
            'slide2Title' => 'An experience <br>unlike any other.',
            'slide2Subtitle' => '모든 사용자에게 특별한 경험을 제공합니다.',
            'slide3Image' => ['path' => 'plugins/alice/theme/assets/img/img_slide3.jpg'],
            'slide3Title' => 'Sharing, <br>Publishing &amp; Pleasure.',
            'slide3Subtitle' => '지식을 나누고 컨텐츠를 출판하며 즐거움을 함께합니다.',
            'logoText' => 'Alice',
            'logoImage' => ['path' => null],
            //'mainMenu' => null,
            'headerPosition' => '',
            'headerColorset' => 'black-header',
            'footerLogoText' => '<i class="xi-xpressengine"></i>',
            'footerLogoImage' => ['path'=>null],
            'footerContents' => 'We made what you need.<br>by XpressEngine',
            'copyright' => 'Copyright © NAVER Corp. Supported by D2 Program.',
            'useFooterLinks' => 'N',
            'footerLinkIcon' => [],
            'footerLinkUrl' => [],
        ];

        app('xe.theme')->setThemeConfig('theme/alice@alice', $default);

        // for main
        $main = [
            '_configId' => 'theme/alice@alice.1',
            '_configTitle' => '메인페이지용',
            'colorset' => '',
            'contentAreaType' => 'xe-container-fluid',
            'layout' => 'main',
            'slide1Image' => ['path' => 'plugins/alice/theme/assets/img/img_slide.jpg'],
            'slide1Title' => 'EVERYTHING<br>YOU NEED',
            'slide1Subtitle' => '당신이 원하는 모든 기능이 이미 준비되어 있습니다.',
            'slide2Image' => ['path' => 'plugins/alice/theme/assets/img/img_slide2.jpg'],
            'slide2Title' => 'An experience <br>unlike any other.',
            'slide2Subtitle' => '모든 사용자에게 특별한 경험을 제공합니다.',
            'slide3Image' => ['path' => 'plugins/alice/theme/assets/img/img_slide3.jpg'],
            'slide3Title' => 'Sharing, <br>Publishing &amp; Pleasure.',
            'slide3Subtitle' => '지식을 나누고 컨텐츠를 출판하며 즐거움을 함께합니다.',
            'logoText' => 'Alice',
            'logoImage' => ['path' => null],
            'mainMenu' => null,
            'headerPosition' => '',
            'headerColorset' => '',
            'footerLogoText' => '<i class="xi-xpressengine"></i>',
            'footerLogoImage' => ['path'=>null],
            'footerContents' => 'We made what you need.<br>by XpressEngine',
            'copyright' => 'Copyright © NAVER Corp. Supported by D2 Program.',
            'useFooterLinks' => 'N',
            'footerLinkIcon' => [],
            'footerLinkUrl' => [],
        ];

        app('xe.theme')->setThemeConfig('theme/alice@alice.1', $main);
    }

    public function update($currentVersion)
    {
    }

    public function checkInstall()
    {
    }

    public function checkUpdate($currentVersion)
    {
    }
}
