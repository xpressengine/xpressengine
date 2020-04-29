<?php
/**
 * MenuMigration.php
 *
 * PHP version 7
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Migrations;

use Illuminate\Database\Schema\Blueprint;
use Schema;
use XeLang;
use Xpressengine\Menu\MenuHandler;
use Xpressengine\Menu\Models\Menu;
use Xpressengine\Menu\Models\MenuItem;
use Xpressengine\Permission\Grant;
use Xpressengine\Plugins\Board\Components\Skins\Board\Blog\BlogSkin;
use Xpressengine\Plugins\Board\Components\Skins\Board\Gallery\GallerySkin;
use Xpressengine\Skin\SkinHandler;
use Xpressengine\Support\Migration;
use Xpressengine\Theme\ThemeHandler;
use Xpressengine\Config\ConfigManager;

/**
 * Class MenuMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class MenuMigration extends Migration
{
    /**
     * Run when install the application.
     *
     * @return void
     */
    public function install()
    {
        Schema::create('menu', function (Blueprint $table) {
            // menu item group
            $table->engine = "InnoDB";

            $table->string('id', 8)->comment('ID');
            $table->string('title')->comment('menu title');
            $table->string('site_key')->comment('site key. for multi web site support.');
            $table->text('description')->nullable()->comment('description');
            $table->integer('count')->default(0)->comment('number of menu item');
            $table->integer('ordering')->default(0)->comment('ordering number for menu sort.');

            $table->primary('id');
        });

        Schema::create('menu_item', function (Blueprint $table) {
            // menu item
            $table->engine = "InnoDB";

            $table->string('id', 8)->comment('ID');
            $table->string('menu_id')->comment('menu ID');
            $table->string('parent_id')->nullable()->comment('parent ID. parent menu item ID.');
            $table->string('title')->comment('menu title. It can be code of translation information.');
            $table->string('url')->comment('URL');
            $table->text('description')->nullable()->comment('menu description. It can be code of translation information.');
            $table->string('target')->comment('HTML <a> tag target attribute value');
            $table->string('type')->comment('Module Type. Module ID of registered this menu item.');
            $table->string('menu_image_id', 36)->nullable()->comment('menu item image');
            $table->string('basic_image_id', 36)->nullable()->comment('image menu item setting');
            $table->string('hover_image_id', 36)->nullable()->comment('image menu item setting');
            $table->string('selected_image_id', 36)->nullable()->comment('image menu item setting');
            $table->string('m_basic_image_id', 36)->nullable()->comment('image menu item setting');
            $table->string('m_hover_image_id', 36)->nullable()->comment('image menu item setting');
            $table->string('m_selected_image_id', 36)->nullable()->comment('image menu item setting');
            $table->integer('ordering')->default(0)->comment('ordering number for menu item sort.');
            $table->boolean('activated')->default(true)->comment('value of menu item activating');
            $table->string('options')->default('')->comment('options');

            $table->primary('id');
        });

        Schema::create('menu_closure', function (Blueprint $table) {
            // menu item tree information
            $table->engine = "InnoDB";

            $table->increments('id')->comment('ID');
            $table->string('ancestor')->comment('parent menu item ID');
            $table->string('descendant')->comment('child menu item ID');
            $table->integer('depth')->comment('depth');
        });
    }

    /**
     * Run after installation.
     *
     * @return void
     */
    public function installed()
    {
        // 홈 메뉴 설정.
        \DB::table('config')->insert(['name' => 'menu', 'vars' => '[]']);
        \DB::table('config')->insert(['name' => 'site', 'vars' => '[]']);
        \DB::table('config')->insert(['name' => 'site.default', 'vars' => '[]']);
    }

    /**
     * Run after service initialized.
     *
     * @return void
     */
    public function initialized()
    {
        // 기본 메뉴 추가 (main) 추가.
        /** @var MenuHandler $menuHandler */
        $menuHandler = app('xe.menu');

        // 기본 메뉴 config  설정 (theme)
        $defaultMenuTheme = 'theme/together@together.0';

        $mainMenu = $menuHandler->createMenu([
            'title' => 'Main Menu',
            'description' => 'Main Menu',
            'site_key' => 'default'
        ]);
        $menuHandler->setMenuTheme($mainMenu, $defaultMenuTheme, $defaultMenuTheme);
        app('xe.permission')->register($mainMenu->getKey(), $menuHandler->getDefaultGrant());

        $this->setThemeConfig($mainMenu->id);

        //for together
        $this->widgetPageModuleMenuSetup($mainMenu);
        $this->boardModuleMenuSetup($mainMenu);
    }

    /**
     * @param null $installedVersion installed version
     *
     * @return bool
     */
    public function checkUpdated($installedVersion = null)
    {
        if ($this->checkExistMenuImageColumn() === false) {
            return false;
        }

        return true;
    }

    /**
     * @param null $installedVersion installed version
     *
     * @return void
     */
    public function update($installedVersion = null)
    {
        if ($this->checkExistMenuImageColumn() === false) {
            $this->createMenuImageColumn();
        }

        if ($this->checkExistMenuOrderingColumn() === false) {
            $this->createMenuOrderingColumn();
        }
    }

    /**
     * check exist menu_item table menu_image_id column
     *
     * @return bool
     */
    private function checkExistMenuImageColumn()
    {
        return Schema::hasColumn('menu_item', 'menu_image_id');
    }

    /**
     * create menu_item table menu_image_id column
     *
     * @return  void
     */
    private function createMenuImageColumn()
    {
        Schema::table('menu_item', function (Blueprint $table) {
            $table->string('menu_image_id', 36)->nullable()->after('type');
        });
    }

    /**
     * check exist menu table ordering column
     *
     * @return bool
     */
    private function checkExistMenuOrderingColumn()
    {
        return Schema::hasColumn('menu', 'ordering');
    }

    /**
     * create menu table ordering column
     *
     * @return  void
     */
    private function createMenuOrderingColumn()
    {
        if ($this->checkExistMenuOrderingColumn() === false) {
            Schema::table('menu', function (Blueprint $table) {
                $table->integer('ordering')->default(0)->comment('ordering number for menu sort.')->after('count');
            });
        }

        $items = \Menu::get();
        foreach ($items as $index => $item) {
            $item->ordering = $index + 1;
            $item->save();
        }

    }

    /**
     * site default config setup
     *
     * @param Menu   $mainMenu menu
     * @param string $homeId   home instance id
     * @return void
     */
    public function siteDefaultConfig($mainMenu, $homeId)
    {
        $site_title = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            $value = "XE3";
            if ($locale != 'ko') {
                $value = "XE3";
            }
            XeLang::save($site_title, $locale, $value, false);
        }

        /**
         * @var $configManager ConfigManager
         */
        $configManager = app('xe.config');
        $configEntity = $configManager->get('site.default');
        $configEntity->set('defaultMenu', $mainMenu->id);
        $configEntity->set('homeInstance', $homeId);
        $configEntity->set('site_title', $site_title);

        $configManager->modify($configEntity);
    }

    public function widgetPageModuleMenuSetup($mainMenu)
    {
        $theme = 'theme/together@together.1';

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
            'menu_id' => $mainMenu->id,
            'parent_id' => null,
            'title' => $menuTitle,
            'url' => 'home',
            'description' => 'home',
            'target' => '',
            'type' => 'widgetpage@widgetpage',
            'ordering' => '1',
            'activated' => '1',
        ];

        $menuTypeInput = [
            'pageTitle' => 'Welcome to XpressEngine3',
            'comment' => false,
            'siteKey' => 'default'
        ];

        $item = $menuHandler->createItem($mainMenu, $inputs, $menuTypeInput);

        $menuHandler->setMenuItemTheme($item, $theme, $theme);
        app('xe.permission')->register($menuHandler->permKeyString($item), new Grant);

        $this->siteDefaultConfig($mainMenu, $item->id);

        return $item;
    }

    /**
     * boardModuleMenuSetup
     *
     * @param Menu $mainMenu
     *
     * @return MenuItem
     */
    public function boardModuleMenuSetup($mainMenu)
    {
        // board, menu item 추가.
        /** @var MenuHandler $menuHandler */
        $menuHandler = app('xe.menu');

        $noticeBoardTitle = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            $value = "Notice";
            if ($locale != 'ko') {
                $value = "Notice";
            }
            XeLang::save($noticeBoardTitle, $locale, $value, false);
        }
        $blogBoardTitle = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            $value = "Blog";
            if ($locale != 'ko') {
                $value = "Blog";
            }
            XeLang::save($blogBoardTitle, $locale, $value, false);
        }
        $boardBoardTitle = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            $value = "Board";
            if ($locale != 'ko') {
                $value = "Board";
            }
            XeLang::save($boardBoardTitle, $locale, $value, false);
        }
        $galleryBoardTitle = XeLang::genUserKey();
        foreach (XeLang::getLocales() as $locale) {
            $value = "Gallery";
            if ($locale != 'ko') {
                $value = "Gallery";
            }
            XeLang::save($galleryBoardTitle, $locale, $value, false);
        }

        $noticeInputs = [
            'menu_id' => $mainMenu->id,
            'parent_id' => null,
            'title' => $noticeBoardTitle,
            'url' => 'notice',
            'description' => 'notice',
            'target' => '',
            'type' => 'board@board',
            'ordering' => '1',
            'activated' => '1',
        ];
        $noticeMenuTypeInput = [
            'page_title' => 'XpressEngine3 Board',
            'board_name' => 'Notice',
            'site_key' => 'default',
            'revision' => 'true',
            'division' => 'false',
        ];
        $noticeItem = $menuHandler->createItem($mainMenu, $noticeInputs, $noticeMenuTypeInput);

        $blogInputs = [
            'menu_id' => $mainMenu->id,
            'parent_id' => null,
            'title' => $blogBoardTitle,
            'url' => 'blog',
            'description' => 'blog',
            'target' => '',
            'type' => 'board@board',
            'ordering' => '2',
            'activated' => '1',
        ];
        $blogMenuTypeInput = [
            'page_title' => 'XpressEngine3 Board',
            'board_name' => 'Blog',
            'site_key' => 'default',
            'revision' => 'true',
            'division' => 'false',
        ];
        $blogItem = $menuHandler->createItem($mainMenu, $blogInputs, $blogMenuTypeInput);

        $boardInputs = [
            'menu_id' => $mainMenu->id,
            'parent_id' => null,
            'title' => $boardBoardTitle,
            'url' => 'board',
            'description' => 'board',
            'target' => '',
            'type' => 'board@board',
            'ordering' => '3',
            'activated' => '1',
        ];
        $boardMenuTypeInput = [
            'page_title' => 'XpressEngine3 Board',
            'board_name' => 'Board',
            'site_key' => 'default',
            'revision' => 'true',
            'division' => 'false',
        ];
        $boardItem = $menuHandler->createItem($mainMenu, $boardInputs, $boardMenuTypeInput);

        $galleryInputs = [
            'menu_id' => $mainMenu->id,
            'parent_id' => null,
            'title' => $galleryBoardTitle,
            'url' => 'gallery',
            'description' => 'gallery',
            'target' => '',
            'type' => 'board@board',
            'ordering' => '4',
            'activated' => '1',
        ];
        $galleryMenuTypeInput = [
            'page_title' => 'XpressEngine3 Board',
            'board_name' => 'Gallery',
            'site_key' => 'default',
            'revision' => 'true',
            'division' => 'false',
        ];
        $galleryItem = $menuHandler->createItem($mainMenu, $galleryInputs, $galleryMenuTypeInput);

        $menuHandler->setMenuItemTheme($noticeItem, null, null);
        $menuHandler->setMenuItemTheme($blogItem, null, null);
        $menuHandler->setMenuItemTheme($boardItem, null, null);
        $menuHandler->setMenuItemTheme($galleryItem, null, null);

        app('xe.permission')->register($menuHandler->permKeyString($noticeItem), new Grant);
        app('xe.permission')->register($menuHandler->permKeyString($blogItem), new Grant);
        app('xe.permission')->register($menuHandler->permKeyString($boardItem), new Grant);
        app('xe.permission')->register($menuHandler->permKeyString($galleryItem), new Grant);

        /** @var SkinHandler $skinHandler */
        $skinHandler = app('xe.skin');

        $blogSkin = $skinHandler->get(BlogSkin::getId());
        $skinHandler->assign('module/board@board:' . $blogItem->id, $blogSkin, 'desktop');
        $skinHandler->assign('module/board@board:' . $blogItem->id, $blogSkin, 'mobile');

        $gallerySkin = $skinHandler->get(GallerySkin::getId());
        $skinHandler->assign('module/board@board:' . $galleryItem->id, $gallerySkin, 'desktop');
        $skinHandler->assign('module/board@board:' . $galleryItem->id, $gallerySkin, 'mobile');
    }

    protected function setThemeConfig($mainMenu)
    {
        /** @var ThemeHandler $themeHandler */
        $themeHandler = app('xe.theme');
        $themeHandler->setThemeConfig('theme/together@together.0', 'mainMenu', $mainMenu);
        $themeHandler->setThemeConfig('theme/together@together.1', 'mainMenu', $mainMenu);
    }
}
