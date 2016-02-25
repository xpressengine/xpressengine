<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use Xpressengine\Menu\MenuEntity;
use Xpressengine\Menu\MenuAlterHandler;
use Xpressengine\Menu\MenuConfigHandler;
use Xpressengine\Menu\MenuItem;
use Xpressengine\Menu\MenuPermissionHandler;
use Xpressengine\Site\SiteHandler;
use Xpressengine\Permission\Grant;
use Xpressengine\Support\Migration;
use Xpressengine\Theme\ThemeHandler;
use Xpressengine\Config\ConfigManager;

class MenuMigration implements Migration {

    public function install()
    {
        Schema::create('menu', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 8);
            $table->string('title');
            $table->string('site');
            $table->text('description')->nullable();

            $table->primary('id');
        });

        Schema::create('menuItem', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->string('id', 8);
            $table->string('menuId');
            $table->string('parentId')->nullable();
            $table->string('title');
            $table->string('url');
            $table->text('description')->nullable();
            $table->string('target');
            $table->string('type');
            $table->integer('ordering');
            $table->boolean('activated');
            $table->string('options');

            $table->primary('id');
        });

        Schema::create('menuTreePath', function (Blueprint $table) {
            $table->engine = "InnoDB";

            $table->increments('id');
            $table->string('ancestor');
            $table->string('descendant');
            $table->integer('depth');
        });

    }

    // seeding.
    public function installed()
    {
        // 홈 메뉴 설정.
        \DB::table('config')->insert(['name' => 'menu', 'vars' => '[]']);
        \DB::table('config')->insert(['name' => 'site', 'vars' => '[]']);
        \DB::table('config')->insert(['name' => 'site.default', 'vars' => '[]']);
    }

    public function init()
    {
        // 기본 메뉴 추가 (main) 추가.
        /**
         * @var $menuChanger MenuAlterHandler
         * @var $configHandler MenuConfigHandler
         * @var $permissionHandler MenuPermissionHandler
         */
        $menuChanger = app('xe.menu.changer');
        $configHandler = app('xe.menu.config');
        $permissionHandler = app('xe.menu.permission');

        $defaultMenuAttributes = [
            'menuTitle' => 'Main Menu',
            'menuDescription' => 'Main Menu',
            'siteKey' => 'default'
        ];

        // 기본 메뉴 config  설정 (theme)
        $defaultMenuTheme = 'theme/alice@main';
        $mainMenu = $menuChanger->addMenu($defaultMenuAttributes);
        $configHandler->setMenuTheme($mainMenu, $defaultMenuTheme, $defaultMenuTheme);

        // 기본 메뉴 권한 설정
        $defaultMenuPermission = $permissionHandler->getDefaultMenuPermission();
        $permissionHandler->registerMenuPermission($mainMenu, $defaultMenuPermission);

        $this->pageModuleMenuSetup($mainMenu);
        $this->boardModuleMenuSetup($mainMenu);

        $this->setThemeConfig($mainMenu->id);

    }

    /**
     * pageModuleMenuSetup
     *
     * @param MenuEntity $mainMenu
     *
     * @return void
     */
    public function pageModuleMenuSetup($mainMenu)
    {

        // page, menu item 추가.
        /**
         * @var $menuChanger MenuAlterHandler
         * @var $configHandler MenuConfigHandler
         * @var $permissionHandler MenuPermissionHandler
         */
        $menuChanger = app('xe.menu.changer');
        $configHandler = app('xe.menu.config');
        $permissionHandler = app('xe.menu.permission');

        $inputs = [
            'menuId' => $mainMenu->id,
            'parent' => $mainMenu->id,
            'itemTitle' => '홈',
            'itemUrl' => 'home',
            'itemDescription' => 'home',
            'itemTarget' => '_blank',
            'selectedType' => 'module/page@page',
            'itemOrdering' => '1',
            'itemActivated' => '1',
            'pageTitle' => 'Welcome to XpressEngine3',
            'comment' => 'use',
            'siteKey' => 'default'
        ];
        $item = $menuChanger->addItem($mainMenu, $inputs);

        $configHandler->setMenuItemTheme($item, 'theme/alice@main', 'theme/alice@main');
        /**
         * @var $configManager ConfigManager
         */
        $configManager = app('xe.config');
        $configEntity = $configManager->get('site.default');
        $configEntity->set('defaultMenu', $mainMenu->id);
        $configEntity->set('homeInstance', $item->id);

        $configManager->modify($configEntity);

        $permissionHandler->registerItemPermission($item, new Grant);

        $this->registerWelcomPageContent($item);
    }

    /**
     * boardModuleMenuSetup
     *
     * @param MenuEntity $mainMenu
     *
     * @return void
     */
    public function boardModuleMenuSetup($mainMenu)
    {
        // board, menu item 추가.
        /**
         * @var $menuChanger MenuAlterHandler
         * @var $configHandler MenuConfigHandler
         * @var $permissionHandler MenuPermissionHandler
         */
        $menuChanger = app('xe.menu.changer');
        $configHandler = app('xe.menu.config');
        $permissionHandler = app('xe.menu.permission');

        $inputs = [
            'menuId' => $mainMenu->id,
            'parent' => $mainMenu->id,
            'itemTitle' => '게시판',
            'itemUrl' => 'board1',
            'itemDescription' => 'board1',
            'itemTarget' => '_blank',
            'selectedType' => 'module/board@board',
            'itemOrdering' => '1',
            'itemActivated' => '1',
            'pageTitle' => 'XpressEngine3 Board',
            'boardName' => 'Board',
            'siteKey' => 'default'
        ];
        $item = $menuChanger->addItem($mainMenu, $inputs);

        $configHandler->setMenuItemTheme($item, 'theme/alice@sub', 'theme/alice@sub');

        $permissionHandler->registerItemPermission($item, new Grant);
    }

    protected function setThemeConfig($mainMenu)
    {
        /** @var ThemeHandler $themeHandler */
        $themeHandler = app('xe.theme');
        $themeHandler->setThemeConfig('theme/alice@main', 'mainmenu', $mainMenu );
    }

    /**
     * update
     *
     * @param string $currentVersion
     *
     * @return void
     */
    public function update($currentVersion)
    {
    }

    /**
     * checkInstall
     *
     * @return void
     */
    public function checkInstall()
    {
    }

    /**
     * checkUpdate
     *
     * @param string $currentVersion
     *
     * @return void
     */
    public function checkUpdate($currentVersion)
    {
    }

    /**
     * registerWelcomPageContent
     *
     * @param MenuItem $item
     *
     * @return void
     * @throws \Exception
     */
    private function registerWelcomPageContent(MenuItem $item)
    {
        $locale = 'ko';
        $handler = app('xe.page.handler');
        $pageConfig = $handler->getPageConfig($item->id);

        $documentUids = $pageConfig->get('pcUids');
        $documentId = $documentUids[$locale];

        $title = "Welcome XE3";
        $content = '
           <div class="section no-pad-bot" id="index-banner">
               <div class="container">
                    <h1 class="header center thin">XE3 Template</h1>
                   <div class="row center">
                        <h5 class="header col s12 light">A modern responsive front-end framework based on Material Design</h5>
                   </div>
               </div>
           </div>
            <hr>
           <div class="container">
               <h2 class="center sub_tit">Features</h2>
               <div class="row center">
                   <p class=" sub_txt">당신이 원하는 모든 기능이 이미 준비되어 있습니다. 무엇보다 서비스에 친화적인 시스템을 가지고 있죠. 모던한 개발기술을 적용하였고 사이트 규모가 커져도 유연하게 대처할 수 있습니다. 지금 XE3의 특징을 경험해보세요.<a href="#" class="btn_more">더 알아보기<i class="xi-angle-right"></i></a></p>
               </div>
           </div>
            <div class="container">
               <div class="section feature">
                   <div class="row">
                       <div class="col s12 m4">
                           <dl>
                           <dt><i class="xo xo-modern"></i>Modern</dt>
                           <dd>Composer를 기반으로한 최신의 php 기능들을 사용하고 packgist의 패키지들과 손쉽게 통합될 수 있습니다.</dd>
                           </dl>
                       </div>
                       <div class="col s12 m4">
                           <dl>
                           <dt><i class="xo xo-extendableg"></i>Extendableg</dt>
                           <dd>자료실을 통해서 다양한 플러그인을 설치하고 사이트를 확장할 수 있습니다. 쉽게 설치하고 쉽게 업데이트 하세요.</dd>
                           </dl>
                       </div>
                       <div class="col s12 m4">
                           <dl>
                           <dt><i class="xo xo-bythepeople"></i>By the people</dt>
                           <dd>chak.it을 통해 자신의 사이트에서 전세계 사용자들과 손쉽게 의견을 주고 받을 수 있습니다.</dd>
                           </dl>
                       </div>
                   </div>
                    <div class="row">
                       <div class="col s12 m4">
                           <dl>
                           <dt><i class="xo xo-socialite"></i>Socialite</dt>
                           <dd>다양한 소셜사이트 정보로 로그인할 수 있고, 원하는 소셜서비스에 대한 기능을 확장할 수 있습니다.</dd>
                           </dl>
                       </div>
                       <div class="col s12 m4">
                           <dl>
                           <dt><i class="xo xo-scalable"></i>Scalable</dt>
                           <dd>사이트 규모가 커졌을 때에도, 유연하게 클라우드 상에서 DB, Storage를 확장할 수 있는 구조를 가지고 있습니다.</dd>
                           </dl>
                       </div>
                       <div class="col s12 m4">
                           <dl>
                           <dt><i class="xo xo-stable"></i>Stable</dt>
                           <dd>선행 깔끔하게 코딩하고 부정 행위처럼 그렇게 쉽게 사용할 수있는 다양한 테마 기능, 당신은 응답 빠르게 제공합니다.</dd>
                           </dl>
                       </div>
                   </div>
               </div>
            </div>';

        $handler->updatePageContent($documentId, $item->id, $content, $title, $locale);
    }
}
