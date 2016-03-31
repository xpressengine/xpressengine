<?php
namespace Xpressengine\Migrations;

use Xpressengine\Support\Migration;
use XeLang;

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

    private function setAliceTheme()
    {
        $logoText = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            XeLang::save($logoText, $locale, "Alice", false);
        }

        $slide1TitleText = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            XeLang::save($slide1TitleText, $locale, "EVERYTHING<br>YOU NEED", false);
        }
        $slide1SubText = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            $value = "당신이 원하는 모든 기능이 이미 준비되어 있습니다.";
            if ($locale != 'ko') {
                $value = "All the features you want are already prepared.";
            }
            XeLang::save($slide1SubText, $locale, $value, false);
        }

        $slide2TitleText = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            XeLang::save($slide2TitleText, $locale, "An experience <br>unlike any other.", false);
        }
        $slide2SubText = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            $value = "모든 사용자에게 특별한 경험을 제공합니다.";
            if ($locale != 'ko') {
                $value = "To all users, providing a special experience.";
            }
            XeLang::save($slide2SubText, $locale, $value, false);
        }

        $slide3TitleText = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            XeLang::save($slide3TitleText, $locale, "Sharing, <br>Publishing &amp; Pleasure.", false);
        }
        $slide3SubText = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            $value = "지식을 나누고 컨텐츠를 출판하며 즐거움을 함께합니다.";
            if ($locale != 'ko') {
                $value = "Publishing content to share knowledge and with pleasure.";
            }
            XeLang::save($slide3SubText, $locale, $value, false);
        }

        $footerLogoText = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            XeLang::save($footerLogoText, $locale, "<i class=\"xi-xpressengine\"></i>", false);
        }
        $footerContents = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            XeLang::save($footerContents, $locale, "XpressEngine", true);
        }

        $config = [
            "subTopImagePath" => '/plugins/alice/assets/img/bg_sub_spot.jpg',
            "footerLogoImagePath" => "",
            "mainContentsAreaType" => "extend",
            "subContentsAreaType" => "fixed",
            "logoType" => "text",
            "logoText" => $logoText,
            "logoImagePath" => "",
            "footerLogoType" => "text",
            "footerLogoText" => $footerLogoText,
            "footerContents" => "XpressEngine",
            "slide1TitleText" => $slide1TitleText,
            "slide1SubText" => $slide1SubText,
            "slide1ImagePath" => '/plugins/alice/assets/img/img_slide.jpg',
            "slide2TitleText" => $slide2TitleText,
            "slide2SubText" => $slide2SubText,
            "slide2ImagePath" => '/plugins/alice/assets/img/img_slide2.jpg',
            "slide3TitleText" => $slide3TitleText,
            "slide3SubText" => $slide3SubText,
            "slide3ImagePath" => '/plugins/alice/assets/img/img_slide3.jpg',
            "useColorSet" => false,
            "useColorValue" => "",
            "mainMenuTheme" => "",
            "mainMenuFixPosition" => true,
            "selectSubMenuThemeAndTopBanner" => "",
            "copyRight" => "Copyright © NAVER Corp. Supported by D2 Program.",
        ];

        app('xe.theme')->setThemeConfig('theme/alice@main', $config);
        app('xe.theme')->setThemeConfig('theme/alice@sub', $config);
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
