<?php
namespace Xpressengine\Migrations;

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
        $theme = ['desktop' => 'theme/alice@site', 'mobile' => 'theme/alice@site'];
        app('xe.theme')->setSiteTheme($theme);

        // set alice theme
        $this->setAliceTheme();
    }

    private function setAliceTheme()
    {
        $config = [
            "title" => "Alice",
            "submenu1_title" => "Settings",
            "submenu2_title" => "Connect",
            "slide_img1Path" => '/plugins/alice/assets/img/pexels-photo2.jpg',
            "slide_img2Path" => '/plugins/alice/assets/img/pexels-photo3.jpg',
            "slide_img3Path" => '/plugins/alice/assets/img/bg_notebook.jpg',
            "slide_videoPath" => '/plugins/alice/assets/img/notebook.mp4',
            "sub_bgPath" => '/plugins/alice/assets/img/bg_sub.jpg',
            "sidemenu_title" => "Sub",
            "mode" => "",
            "bg_none" => "bg_none",
            "header_scroll" => "blue_scroll",
            "no_snb" => "no_snb",
        ];

        app('xe.theme')->setThemeConfig('theme/alice@main', $config);
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
