<?php
namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use XeLang;
use Xpressengine\Menu\MenuHandler;
use Xpressengine\Menu\Models\Menu;
use Xpressengine\Menu\Models\MenuItem;
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
            $table->string('siteKey');
            $table->text('description')->nullable();
            $table->integer('count');

            $table->primary('id');
        });

        Schema::create('menu_item', function (Blueprint $table) {
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

        Schema::create('menu_closure', function (Blueprint $table) {
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
        /** @var MenuHandler $menuHandler */
        $menuHandler = app('xe.menu');

        // 기본 메뉴 config  설정 (theme)
        $defaultMenuTheme = 'theme/alice@main';

        $mainMenu = $menuHandler->create([
            'title' => 'Main Menu',
            'description' => 'Main Menu',
            'siteKey' => 'default'
        ]);
        $menuHandler->setMenuTheme($mainMenu, $defaultMenuTheme, $defaultMenuTheme);

        $this->pageModuleMenuSetup($mainMenu);
        $this->boardModuleMenuSetup($mainMenu);

        $this->setThemeConfig($mainMenu->id);

    }

    /**
     * pageModuleMenuSetup
     *
     * @param Menu $mainMenu
     *
     * @return void
     */
    public function pageModuleMenuSetup($mainMenu)
    {

        // page, menu item 추가.
        /** @var MenuHandler $menuHandler */
        $menuHandler = app('xe.menu');

        $menuTitle = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            $value = "홈";
            if ($locale != 'ko') {
                $value = "Home";
            }
            XeLang::save($menuTitle, $locale, $value, false);
        }

        $inputs = [
            'menuId' => $mainMenu->id,
            'parentId' => null,
            'title' => $menuTitle,
            'url' => 'home',
            'description' => 'home',
            'target' => '_blank',
            'type' => 'module/page@page',
            'ordering' => '1',
            'activated' => '1',
        ];
        $menuTypeInput = [
            'pageTitle' => 'Welcome to XpressEngine3',
            'comment' => false,
            'siteKey' => 'default'
        ];

        $item = $menuHandler->createItem($mainMenu, $inputs, $menuTypeInput);

        $menuHandler->setMenuItemTheme($item, 'theme/alice@main', 'theme/alice@main');
        /**
         * @var $configManager ConfigManager
         */
        $configManager = app('xe.config');
        $configEntity = $configManager->get('site.default');
        $configEntity->set('defaultMenu', $mainMenu->id);
        $configEntity->set('homeInstance', $item->id);

        $configManager->modify($configEntity);

        $this->registerWelcomPageContent($item);
    }

    /**
     * boardModuleMenuSetup
     *
     * @param Menu $mainMenu
     *
     * @return void
     */
    public function boardModuleMenuSetup($mainMenu)
    {
        // board, menu item 추가.
        /** @var MenuHandler $menuHandler */
        $menuHandler = app('xe.menu');

        $menuTitle = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            $value = "게시판";
            if ($locale != 'ko') {
                $value = "Board";
            }
            XeLang::save($menuTitle, $locale, $value, false);
        }

        $inputs = [
            'menuId' => $mainMenu->id,
            'parentId' => null,
            'title' => $menuTitle,
            'url' => 'board1',
            'description' => 'board1',
            'target' => '_blank',
            'type' => 'module/board@board',
            'ordering' => '1',
            'activated' => '1',
        ];
        $menuTypeInput = [
            'pageTitle' => 'XpressEngine3 Board',
            'boardName' => 'Board',
            'siteKey' => 'default',
            'revision' => 'true',
            'division' => 'false',
        ];

        $item = $menuHandler->createItem($mainMenu, $inputs, $menuTypeInput);

        $menuHandler->setMenuItemTheme($item, 'theme/alice@sub', 'theme/alice@sub');
    }

    protected function setThemeConfig($mainMenu)
    {
        /** @var ThemeHandler $themeHandler */
        $themeHandler = app('xe.theme');
        $themeHandler->setThemeConfig('alice', 'mainMenu', $mainMenu );
        $themeHandler->setThemeConfig('alice', 'subMenu', $mainMenu );
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
           <div class="xe-row">
		<!--content area -->
			<div class="content welcome">
				<div class="content-inner xe-container">
					<h2>WELCOME</h2>
					<strong>There are a million reasons to use XE3.</strong>
					<p>XpressEngine은 자유로운 웹 콘텐츠 발행을 돕는 CMS입니다. Laravel framework 기반의 XE3는 다양한 번들 시스템으로 빠른 피드백을 제공하고 유연한 확장성을 자랑합니다.</p>
					<a href="http://xpressengine.io/features" class="link-info">안내 페이지 바로가기</a>
				</div>
			</div>
			<div class="content theme">
				<div class="content-inner xe-container">
					<h2>DISCOVER</h2>
					<strong>XE3 Theme Alice.</strong>
					<p>XE3의 테마 앨리스는 모바일, 타블렛, 데스크탑 스크린 모두에 적합한 레이아웃을 제공합니다. 또한 홈페이지 특징에 맞게 사용할 수 있는 여러가지 컬러 테마를 지원하죠.</p>
					<div class="num xe-hidden-xs">
						<span class="on"></span>
						<span class="blue"></span>
						<span class="red"></span>
					</div>
				</div>
				<div class="owl-wrap">
					<div id="owl-color" class="owl-color xe-hidden-xs">
						<div class="item">
							<div class="theme-color">
								<div class="diagonal-area"></div>
							</div>
						</div>
						<div class="item">
							<div class="theme-color blue-bg">
								<div class="diagonal-area"></div>
							</div>
						</div>
						<div class="item">
							<div class="theme-color red-bg">
								<div class="diagonal-area"></div>
							</div>
						</div>
					</div>
					<div class="owl-inner">
						<div id="owl-mobile" class="owl-mobile">
							<div class="item">
								<div class="bg-img brown"></div>
							</div>
							<div class="item">
								<div class="bg-img blue"></div>
							</div>
							<div class="item">
								<div class="bg-img red"></div>
							</div>
						</div>
						<div id="owl-tablet" class="owl-tablet xe-hidden-xs">
							<div class="item">
								<div class="bg-img brown"></div>
							</div>
							<div class="item">
								<div class="bg-img blue"></div>
							</div>
							<div class="item">
								<div class="bg-img red"></div>
							</div>
						</div>
						<div id="owl-pc" class="owl-pc xe-visible-lg">
							<div class="item">
								<div class="bg-img brown"></div>
							</div>
							<div class="item">
								<div class="bg-img blue"></div>
							</div>
							<div class="item">
								<div class="bg-img red"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="content stater">
				<div class="content-inner xe-container">
					<h2>GUIDE</h2>
					<strong>For starter.</strong>
					<div class="xe-row">
						<div class="xe-col-sm-6">
							<div class="start-guide">
								<i class="xi-home-o"></i>
								<dl>
									<dt>사이트 기본 설정</dt>
									<dd>홈페이지 기본 설정을 변경해 보세요.<br><a href="'.route('settings.setting.edit').'">사이트관리 > 설정 > 사이트 기본설정</a>에서 사이트 제목을 설정할 수 있습니다.</dd>
								</dl>
							</div>
						</div>
						<div class="xe-col-sm-6">
							<div class="start-guide">
								<i class="xi-laptop"></i>
								<dl>
									<dt>초기화면 바꾸기</dt>
									<dd>사이트 홈을 설정해 보세요.<br><a href="'.route('settings.menu.index').'">사이트관리 > 사이트맵 > 사이트 메뉴 편집</a>에서 홈을 설정합니다.</dd>
								</dl>
							</div>
						</div>
					</div>
					<div class="xe-row">
						<div class="xe-col-sm-6">
							<div class="start-guide">
								<i class="xi-sitemap-o"></i>
								<dl>
									<dt>메뉴 구조 구성하기</dt>
									<dd>메뉴를 만들어 사이트맵을 구성해 보세요.<br><a href="'.route('settings.menu.index').'">사이트관리 > 사이트맵 > 사이트 메뉴 편집</a>에서 메뉴를 설정합니다.</dd>
								</dl>
							</div>
						</div>
						<div class="xe-col-sm-6">
							<div class="start-guide">
								<i class="xi-windows-text"></i>
								<dl>
									<dt>테마 디자인 변경하기</dt>
									<dd>XE3는 별도의 테마 디자인을 제공합니다. 레이아웃 디자인은 <a href="'.route('settings.setting.edit').'">사이트관리 > 설정 > 사이트 기본설정</a>에서 변경할 수 있습니다. </dd>
								</dl>
							</div>
						</div>
					</div>
					<div class="xe-row">
						<div class="xe-col-sm-6">
							<div class="start-guide">
								<i class="xi-plus-circle-o"></i>
								<dl>
									<dt>플러그인 관리하기</dt>
									<dd><a href="#">자료실</a>에서 플러그인을 설치하여 사이트를 풍성하게 만들어 보세요. 플러그인은 <a href="'.route('settings.plugins').'">사이트관리 > 플러그인 > 플러그인 목록</a>에서 설정할 수 있습니다.</dd>
								</dl>
							</div>
						</div>
						<div class="xe-col-sm-6">
							<div class="start-guide">
								<i class="xi-lock"></i>
								<dl>
									<dt>관리페이지 권한 설정하기</dt>
									<dd>사이트의 관리 권한을 설정하세요. 사이트의 관리 권한 설정은 <a href="'.route('settings.setting.permissions').'">사이트관리 > 설정 > 관리페이지 권한 설정</a>에서 수정할 수 있습니다.</dd>
								</dl>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="content involve">
				<div class="involve-inner xe-container">
					<h2>Get involved</h2>
					<p>XpressEngine3는 많은사람들이 함께 만들어가는 오픈소스 프로젝트입니다.<br>GitHub Project에서 개발 현황을 살펴보고 개발에 참여해보세요  </p>
					<a href="https://github.com/xpressengine/xpressengine">GitHub Project</a>
				</div>
			</div>
			<div class="content support">
				<div class="content-inner xe-container">
					<h2>SUPPORT</h2>
					<strong>XpressEngine Communities</strong>
					<p>XpressEngine의 정보를 교환하고 토론, 토의할 수 있는 공간에 참여할 수 있습니다. Slack 공식 채널과 여러 커뮤니티에서 다양한 정보를 나눌 수 있습니다.</p>
					<div class="xe-row support-list">
						<div class="xe-col-md-4">
							<div class="support-img">
							</div>
							<div class="support-txt">
								<div class="table-txt">
									<div>
										<dl>
											<dt>XE Forum Chat</dt>
											<dd>XE 오픈소스 프로젝트 참여자 간 실시간 정보 교환을 할 수 있는 Slack 채널입니다.</dd>
										</dl>
										<a href="https://xeforum.slack.com/" target="_blank">XE Slack 바로가기</a>
									</div>
								</div>
							</div>
						</div>
						<div class="xe-col-md-4">
							<div class="support-img second">
							</div>
							<div class="support-txt">
								<div class="table-txt">
									<div>
										<dl>
											<dt>XE Facebook Group</dt>
											<dd>XE 자료를 만들고 배포하거나 의견을 공유하며 행사일정을 확인할 수 있습니다.</dd>
										</dl>
										<a href="https://www.facebook.com/xehub" target="_blank">XE Facebook Group 바로가기</a>
									</div>
								</div>
							</div>
						</div>
						<div class="xe-col-md-4">
							<div class="support-img third">
							</div>
							<div class="support-txt">
								<div class="table-txt">
									<div>
										<dl>
											<dt>XE Town</dt>
											<dd>XpressEngine 사용자들에게 가장 인기있는 커뮤니티입니다.</dd>
										</dl>
										<a href="https://www.xetown.com/" target="_blank">XE Town 바로가기</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="content parallax">
				<div class="xe-container">
					<strong>We made<br>what you need.</strong>
					<div class="rectangle">
						<p>by <a href="http://xpressengine.io/">XpressEngine.io</a></p>
					</div>
				</div>
			</div>
		<!--// content area -->
		</div>';

        $handler->updatePageContent($documentId, $item->id, $content, $title, $locale);
    }
}
