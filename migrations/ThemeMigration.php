<?php
/**
 * ThemeMigration.php
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

use XeLang;
use Xpressengine\Media\Models\Image;
use Xpressengine\Plugins\Banner\Widgets\Widget;
use Xpressengine\Plugins\Board\Components\Widgets\ArticleList\ArticleListWidget;
use Xpressengine\Plugins\Together\Components\Skins\ArticleList\Gallery\GallerySkin;
use Xpressengine\Plugins\Together\Components\Skins\ArticleList\Latest\LatestSkin;
use Xpressengine\Plugins\Together\Components\Skins\ArticleList\Media\MediaSkin;
use Xpressengine\Plugins\Together\Components\Skins\ArticleList\Notice\NoticeSkin;
use Xpressengine\Plugins\Together\Components\Skins\Banner\Category\CategorySkin;
use Xpressengine\Plugins\Together\Components\Skins\Banner\Dday\DdaySkin;
use Xpressengine\Plugins\Together\Plugin;
use Xpressengine\Support\Migration;

/**
 * Class ThemeMigration
 *
 * @category    Migrations
 * @package     Xpressengine\Migrations
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ThemeMigration extends Migration
{
    const NOTICE_TYPE = 'notice';
    const BLOG_TYPE = 'blog';
    const BOARD_TYPE = 'board';
    const GALLERY_TYPE = 'gallery';

    /**
     * Run after installation.
     *
     * @return void
     */
    public function installed()
    {
        \DB::table('config')->insert(
            [
                ['name' => 'theme', 'vars' => '[]'],
                ['name' => 'theme.settings', 'vars' => '[]'],
                ['name' => 'theme.settings.theme/together@together', 'vars' => '[]']
            ]
        );
    }

    /**
     * Run after initialized.
     *
     * @return void
     */
    public function initialized()
    {
        // set site default theme
        $theme = ['desktop' => 'theme/together@together.0', 'mobile' => 'theme/together@together.0'];
        app('xe.theme')->setSiteTheme($theme);

        // set alice theme
        $this->setTogetherTheme();

        $siteKey = \XeSite::getCurrentSiteKey();
        $menus = \XeMenu::menus()->fetchBySiteKey($siteKey, 'items')->getDictionary();

        $widgetpageId = '';
        $noticeBoardId = '';
        $blogBoardId = '';
        $boardBoardId = '';
        $galleryBoardId = '';

        foreach ($menus as $menu) {
            foreach ($menu->items as $menuItem) {
                if ($menuItem->type == 'board@board') {
                    switch ($menuItem->url) {
                        case self::NOTICE_TYPE:
                            $noticeBoardId = $menuItem->id;
                            break;

                        case self::BLOG_TYPE:
                            $blogBoardId = $menuItem->id;
                            break;

                        case self::BOARD_TYPE:
                            $boardBoardId = $menuItem->id;
                            break;

                        case self::GALLERY_TYPE:
                            $galleryBoardId = $menuItem->id;
                            break;
                    }
                } elseif ($menuItem->type == 'widgetpage@widgetpage') {
                    $widgetpageId = $menuItem->id;
                }
            }
        }

        $this->storeBoardContents(self::NOTICE_TYPE, $noticeBoardId);
        $this->storeBoardContents(self::BLOG_TYPE, $blogBoardId);
        $this->storeBoardContents(self::BOARD_TYPE, $boardBoardId);
        $this->storeBoardContents(self::GALLERY_TYPE, $galleryBoardId);

        $boardIds = [
            'notice' => $noticeBoardId,
            'blog' => $blogBoardId,
            'board' => $boardBoardId,
            'gallery' => $galleryBoardId
        ];

        $this->settingWidgetpage($widgetpageId, $boardIds);
    }

    public function setTogetherTheme()
    {
        $multiLines = [
            'headerTitle' => [
                'ko' => 'Welcome!' . PHP_EOL . 'XE3 Theme Together',
                'en' => 'Welcome!' . PHP_EOL . 'XE3 Theme Together'
            ],
            'headerDescription' => [
                'ko' => 'XE3에 오신걸 환영합니다.' . PHP_EOL . 'XE3와 함께 손쉬운 나만의 웹사이트를 만들어보세요.',
                'en' => 'Welcome to XE3.' . PHP_EOL . 'Create your personalized website with XE3.'
            ]
        ];

        foreach ($multiLines as $key => $lang) {
            $langKey = XeLang::genUserKey();
            XeLang::save($langKey, 'ko', $lang['ko'], true);
            $multiLines[$key] = $langKey;
        }

        $singleLines = [
            'logoText' => [
                'ko' => 'Together',
                'en' => 'Together'
            ],
            'slogan' => [
                'ko' => 'Welcome! XE3 Theme Together',
                'en' => 'Welcome! XE3 Theme Together'
            ]
        ];

        foreach ($singleLines as $key => $lang) {
            $langKey = XeLang::genUserKey();
            XeLang::save($langKey, 'ko', $lang['ko'], false);
            $singleLines[$key] = $langKey;
        }

        $default = [
            '_configId' => 'theme/together@together.0',
            '_configTitle' => '기본',
            'layoutType' => 'sub',
            'logoType' => 'text',
            'logoImage' => ['path' => null],
            'useMainHeader' => 'N',
            'useSnb' => 'Y',
            'socialTwitter' => '',
            'socialYoutube' => '',
            'socialInstagram' => '',
            'socialFacebook' => '',
            'useCopyright' => 'Y',
            'copyrightContent' => '',
        ];

        app('xe.theme')->setThemeConfig('theme/together@together.0', array_merge($default, $multiLines, $singleLines));

        $imgInfo = $this->storeImage(Plugin::path('assets/images/demo_images/main_img.jpg'), 'main_image.jpg');
        $image = Image::find($imgInfo['id']);
        $main = [
            '_configId' => 'theme/together@together.1',
            '_configTitle' => '메인페이지용',
            'layoutType' => 'main',
            'useMainHeader' => 'Y',
            'headerImage' => [
                'id' => $imgInfo['id'],
                'path' => $image->url(),
                'filename' => $image->filename
            ],
        ];

        app('xe.theme')->setThemeConfig('theme/together@together.1', array_merge($default, $main, $multiLines, $singleLines));
    }

    public function storeBoardContents($boardType, $boardId)
    {
        $config = app('xe.board.config')->get($boardId);

        $contents = [];
        switch ($boardType) {
            case self::NOTICE_TYPE:
                $contents = $this->getNoticeBoardContents();
                break;

            case self::BLOG_TYPE:
                $contents = $this->getBlogBoardContents();
                break;

            case self::BOARD_TYPE:
                $contents = $this->getBoardBoardContents();
                break;

            case self::GALLERY_TYPE:
                $contents = $this->getGalleryBoardContents();
                break;
        }

        $startTime = time();
        $contentCount = 0;
        foreach ($contents as $content) {
            $content['instance_id'] = $boardId;

            $boardItem = app('xe.board.handler')->add($content, \Auth::user(), $config);

            $newWriteTimeTimestamp = strtotime('+' . $contentCount++ . ' minutes', $startTime);
            $newWriteTimeString = date('Y-m-d H:i:s', $newWriteTimeTimestamp);

            $boardItem->head = $newWriteTimeTimestamp . '-' . $boardItem->id;
            $boardItem->created_at = $newWriteTimeString;
            $boardItem->updated_at = $newWriteTimeString;

            $boardItem->save();
        }
    }

    public function getNoticeBoardContents()
    {
        $firstExampleImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/board_banner_setting_first_ex.png'), 'board_banner_setting_first_ex.png');
        $secondExampleImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/board_banner_setting_second_ex.png'), 'board_banner_setting_second_ex.png');
        $contents[] = [
            'title' => 'D-Day 배너 설정하기',
            'slug' => 'D-Day 배너 설정하기',
            'content' => '<img class="__xe_image" data-id="' . $firstExampleImageInfo['id'] . '" src="' . $firstExampleImageInfo['path'] .
                '" xe-file-id="' . $firstExampleImageInfo['id'] . '" alt="' . $firstExampleImageInfo['filename'] . '" /><br/>' .
                '<img class="__xe_image" data-id="' . $secondExampleImageInfo['id'] . '" src="' . $secondExampleImageInfo['path'] .
                '" xe-file-id="' . $secondExampleImageInfo['id'] . '" alt="' . $secondExampleImageInfo['filename'] . '" />'
                . '<p>메인 페이지의 D-Day 배너를 설정하세요.<br/>
배너 설정은 <a href="'.route('settings.setting.permissions').'" target="_blank">사이트관리 > 플러그인 > 설치된 플러그인 > 배너 설정</a>에서 설정할 수 있습니다.</p>',
            '_coverId' => '',
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        $exampleImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/board_site_permission_ex.png'), 'board_site_permission_ex.png');
        $contents[] = [
            'title' => '관리페이지 권한 설정하기',
            'slug' => '관리페이지 권한 설정하기',
            'content' => '<img class="__xe_image" data-id="' . $exampleImageInfo['id'] . '" src="' . $exampleImageInfo['path'] .
                '" xe-file-id="' . $exampleImageInfo['id'] . '" alt="' . $exampleImageInfo['filename'] . '" />'
                . '<p>사이트의 관리 권한을 설정하세요.<br/>
권한 설정은 <a href="'.route('settings.setting.permissions').'" target="_blank">사이트관리 > 설정 > 관리페이지 권한 설정</a>에서 수정할 수 있습니다.</p>',
            '_coverId' => '',
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        return $contents;
    }

    public function getBlogBoardContents()
    {
        $thumbNailInfo = $this->storeImage(Plugin::path('assets/images/demo_images/blog6_thumb.jpg'), 'blog6_thumb.jpg');
        $themeImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/theme_install.png'), 'theme_install.png');
        $extensionImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/extension_install.png'), 'extension_install.png');
        $contents[] = [
            'title' => '플러그인 관리하기',
            'slug' => '플러그인 관리하기',
            'content' => '<p>스토어에서 플러그인을 설치하여 사이트를 풍성하게 만들어보세요.<br/>' .
                '<img class="__xe_image" data-id="' . $themeImageInfo['id'] . '" src="' . $themeImageInfo['path'] .
                '" xe-file-id="' . $themeImageInfo['id'] . '" alt="' . $themeImageInfo['filename'] . '" />'
                . '<br/>테마는 <a href="'.route('settings.theme.install').'" target="_blank">사이트관리 > 테마 > 테마 추가</a>에서 추가 할 수 있습니다.<br/><br/>'
                . '<img class="__xe_image" data-id="' . $extensionImageInfo['id'] . '" src="' . $extensionImageInfo['path'] .
                '" xe-file-id="' . $extensionImageInfo['id'] . '" alt="' . $extensionImageInfo['filename'] . '" />'
                . '<br/>익스텐션은 <a href="'.route('settings.extension.install').'" target="_blank">사이트관리 > 익스텐션 > 익스텐션 추가</a>에서 추가 할 수 있습니다.</p>',
            '_coverId' => $thumbNailInfo['id'],
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        $thumbNailInfo = $this->storeImage(Plugin::path('assets/images/demo_images/blog5_thumb.jpg'), 'blog5_thumb.jpg');
        $exampleImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/board_theme_ex.png'), 'board_theme_ex.png');
        $contents[] = [
            'title' => '테마 디자인 변경하기',
            'slug' => '테마 디자인 변경하기',
            'content' => '<img class="__xe_image" data-id="' . $exampleImageInfo['id'] . '" src="' . $exampleImageInfo['path'] .
                '" xe-file-id="' . $exampleImageInfo['id'] . '" alt="' . $exampleImageInfo['filename'] . '" />'
                . '<p>다른 테마가 필요하신가요? 내가 만든 테마를 적용하고 싶으신가요?<br/><a href="'.route('settings.edit.theme').'" target="_blank">사이트관리 > 테마 > 테마 설정</a>에서 변경할 수 있습니다.</p>',
            '_coverId' => $thumbNailInfo['id'],
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        $thumbNailInfo = $this->storeImage(Plugin::path('assets/images/demo_images/blog4_thumb.jpg'), 'blog4_thumb.jpg');
        $exampleImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/board_sitemap_menu_ex.png'), 'board_sitemap_menu_ex.png');
        $contents[] = [
            'title' => '메뉴 구조 구성하기',
            'slug' => '메뉴 구조 구성하기',
            'content' => '<img class="__xe_image" data-id="' . $exampleImageInfo['id'] . '" src="' . $exampleImageInfo['path'] .
                '" xe-file-id="' . $exampleImageInfo['id'] . '" alt="' . $exampleImageInfo['filename'] . '" />'
                . '<p>메뉴를 만들어 사이트맵을 구성해보세요.<br/><a href="'.route('settings.menu.index').'" target="_blank">사이트 관리 > 사이트맵 > 사이트메뉴 편집</a>에서 메뉴를 설정합니다.</p>',
            '_coverId' => $thumbNailInfo['id'],
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        $thumbNailInfo = $this->storeImage(Plugin::path('assets/images/demo_images/blog3_thumb.jpg'), 'blog3_thumb.jpg');
        $exampleImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/board_sitemap_home_ex.png'), 'board_sitemap_home_ex.png');
        $contents[] = [
            'title' => '홈 화면 변경하기',
            'slug' => '홈 화면 변경하기',
            'content' => '<img class="__xe_image" data-id="' . $exampleImageInfo['id'] . '" src="' . $exampleImageInfo['path'] .
                '" xe-file-id="' . $exampleImageInfo['id'] . '" alt="' . $exampleImageInfo['filename'] . '" />'
                . '<p>사이트 홈을 설정해 보세요.<br/><a href="'.route('settings.menu.index').'" target="_blank">사이트 관리 > 사이트맵 > 사이트 메뉴 편집</a>에서 홈을 설정합니다.</p>',
            '_coverId' => $thumbNailInfo['id'],
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        $thumbNailInfo = $this->storeImage(Plugin::path('assets/images/demo_images/blog2_thumb.jpg'), 'blog2_thumb.jpg');
        $exampleImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/board_site_setting_ex.png'), 'board_site_setting_ex.png');
        $contents[] = [
            'title' => '사이트 기본 설정을 확인해보세요',
            'slug' => '사이트 기본 설정을 확인해보세요',
            'content' => '<img class="__xe_image" data-id="' . $exampleImageInfo['id'] . '" src="' . $exampleImageInfo['path'] .
                '" xe-file-id="' . $exampleImageInfo['id'] . '" alt="' . $exampleImageInfo['filename'] . '" />'
                . '<p>홈페이지 기본 설정을 변경해 보세요.<br/><a href="'.route('settings.setting.edit').'" target="_blank">사이트 관리 > 설정 > 사이트 기본설정</a>에서 사이트 제목을 설정할 수 있습니다.</p>',
            '_coverId' => $thumbNailInfo['id'],
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        $thumbNailInfo = $this->storeImage(Plugin::path('assets/images/demo_images/blog1_thumb.jpg'), 'blog1_thumb.jpg');
        $defaultSkinImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/default_skin.png'), 'default_skin.png');
        $gallerySkinImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/gallery_skin.png'), 'gallery_skin.png');
        $blogSkinImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/blog_skin.png'), 'blog_skin.png');
        $ddaySampleImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/dday_sample.png'), 'dday_sample.png');
        $contents[] = [
            'title' => 'XE Theme Together를 소개합니다',
            'slug' => 'XE Theme Together를 소개합니다',
            'content' => '<p>XE3 공식테마 Together를 설치해주셔서 감사합니다.<br/>다양한 게시판 위젯과 디데이, 카테고리 위젯을 제공하고 있습니다.<br/>Together theme로 개성있는 나만의 웹 사이트를 제작해보세요.<br/></p>' .
                '<p><span style="font-size:16px;"><b>◆ 원하는 형태의 게시판을 게시판 스킨 변경으로 자유롭게 배치해보세요</b></span></p>' .
                '<img class="__xe_image" data-id="' . $defaultSkinImageInfo['id'] . '" src="' . $defaultSkinImageInfo['path'] .
                '" xe-file-id="' . $defaultSkinImageInfo['id'] . '" alt="' . $defaultSkinImageInfo['filename'] . '" />' .
                '<p>리스트형 게시판 (기본)</p>' .
                '<img class="__xe_image" data-id="' . $gallerySkinImageInfo['id'] . '" src="' . $gallerySkinImageInfo['path'] .
                '" xe-file-id="' . $gallerySkinImageInfo['id'] . '" alt="' . $gallerySkinImageInfo['filename'] . '" />' .
                '<p>갤러리형 게시판</p>' .
                '<img class="__xe_image" data-id="' . $blogSkinImageInfo['id'] . '" src="' . $blogSkinImageInfo['path'] .
                '" xe-file-id="' . $blogSkinImageInfo['id'] . '" alt="' . $blogSkinImageInfo['filename'] . '" />' .
                '<p>블로그형 게시판</p>' .
                '<p><span style="font-size:16px;"><b>◆ D day 위젯을 통해 중요 알림을 공지해보세요</b></span></p>' .
                '<img class="__xe_image" data-id="' . $ddaySampleImageInfo['id'] . '" src="' . $ddaySampleImageInfo['path'] .
                '" xe-file-id="' . $ddaySampleImageInfo['id'] . '" alt="' . $ddaySampleImageInfo['filename'] . '" />',
            '_coverId' => $thumbNailInfo['id'],
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        return $contents;
    }

    public function getBoardBoardContents()
    {
        $exampleImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/board4.png'), 'board4.png');
        $contents[] = [
            'title' => '스토어는 왜 베타인가요?',
            'slug' => '스토어는 왜 베타인가요?',
            'content' => '<img class="__xe_image" data-id="' . $exampleImageInfo['id'] . '" src="' . $exampleImageInfo['path'] .
                '" xe-file-id="' . $exampleImageInfo['id'] . '" alt="' . $exampleImageInfo['filename'] . '" />'
                . '<p>베타 기간동안 창작자를 위해 플랫폼 수수료를 대폭 낮추고 XEHub에서 기술지원을 드리려고 합니다.<br/>무료, 유료 플러그인이 유통되기 시작하면 정식 오픈을 할 예정이니, 창작자로서 참여하고 싶다면 서두르세요!</p>',
            '_coverId' => '',
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        $exampleImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/board3.png'), 'board3.png');
        $contents[] = [
            'title' => '창작자를 위해 준비했어요!',
            'slug' => '창작자를 위해 준비했어요!',
            'content' => '<img class="__xe_image" data-id="' . $exampleImageInfo['id'] . '" src="' . $exampleImageInfo['path'] .
                '" xe-file-id="' . $exampleImageInfo['id'] . '" alt="' . $exampleImageInfo['filename'] . '" />'
                . '<p>XEHub는 창작자분들의 창의성을 응원하고 다양한 프로그램을 통해 열심히 도움을 드립니다.<br/>XE Study에 참여하여 창작자가 될 수 있고, 초기 판매자가 되어 XE의 플러그인 시장을 확보할 수도 있습니다.</p>',
            '_coverId' => '',
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        $exampleImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/board2.png'), 'board2.png');
        $contents[] = [
            'title' => 'XE창작자는 무엇인가요?',
            'slug' => 'XE창작자는 무엇인가요?',
            'content' => '<img class="__xe_image" data-id="' . $exampleImageInfo['id'] . '" src="' . $exampleImageInfo['path'] .
                '" xe-file-id="' . $exampleImageInfo['id'] . '" alt="' . $exampleImageInfo['filename'] . '" />'
                . '<p>XE Store에서 창작자는 무료로 개발한 플러그인을 오픈소스로 공개하여 사용자의 피드백을 받아볼 수 있고,<br/>유료 플러그인을 게시하여 창작자가 만든 제품의 가치만큼 수익을 얻을 수 있습니다.<br/>여러분의 번뜩이는 아이디어와 지식으로 아직 부족한 XE Store를 가득 채우기를 고대하고 있어요.</p>',
            '_coverId' => '',
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        $exampleImageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/board1.png'), 'board1.png');
        $contents[] = [
            'title' => '스토어는 어떤 공간인가요?',
            'slug' => '스토어는 어떤 공간인가요?',
            'content' => '<img class="__xe_image" data-id="' . $exampleImageInfo['id'] . '" src="' . $exampleImageInfo['path'] .
                '" xe-file-id="' . $exampleImageInfo['id'] . '" alt="' . $exampleImageInfo['filename'] . '" />'
                . '<p>창작자는 자신이 만든 플러그인을 공개하거나 판매할 수 있고,<br/>XE3 사용자는 Store를 통해 마음에 드는 플러그인을 골라 웹사이트의 기능을 확장하고 아름답게 꾸밀 수 있습니다.</p>',
            '_coverId' => '',
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        return $contents;
    }

    public function getGalleryBoardContents()
    {
        $thumbNailInfo = $this->storeImage(Plugin::path('assets/images/demo_images/gallery1.jpg'), 'gallery1.jpg');
        $contents[] = [
            'title' => 'gallery1',
            'slug' => 'gallery1',
            'content' => '<p></p>',
            '_coverId' => $thumbNailInfo['id'],
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        $thumbNailInfo = $this->storeImage(Plugin::path('assets/images/demo_images/gallery2.jpg'), 'gallery2.jpg');
        $contents[] = [
            'title' => 'gallery2',
            'slug' => 'gallery2',
            'content' => '<p></p>',
            '_coverId' => $thumbNailInfo['id'],
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        $thumbNailInfo = $this->storeImage(Plugin::path('assets/images/demo_images/gallery3.jpg'), 'gallery3.jpg');
        $contents[] = [
            'title' => 'gallery3',
            'slug' => 'gallery3',
            'content' => '<p></p>',
            '_coverId' => $thumbNailInfo['id'],
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        $thumbNailInfo = $this->storeImage(Plugin::path('assets/images/demo_images/gallery4.jpg'), 'gallery4.jpg');
        $contents[] = [
            'title' => 'gallery4',
            'slug' => 'gallery4',
            'content' => '<p></p>',
            '_coverId' => $thumbNailInfo['id'],
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        $thumbNailInfo = $this->storeImage(Plugin::path('assets/images/demo_images/gallery5.jpg'), 'gallery5.jpg');
        $contents[] = [
            'title' => 'gallery5',
            'slug' => 'gallery5',
            'content' => '<p></p>',
            '_coverId' => $thumbNailInfo['id'],
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        $thumbNailInfo = $this->storeImage(Plugin::path('assets/images/demo_images/gallery6.jpg'), 'gallery6.jpg');
        $contents[] = [
            'title' => 'gallery6',
            'slug' => 'gallery6',
            'content' => '<p></p>',
            '_coverId' => $thumbNailInfo['id'],
            'allow_comment' => '1',
            'use_alarm' => '1',
            'file' => null,
            'format' => 10,
            '_files' => [],
            '_hashTags' => [],
        ];

        return $contents;
    }

    public function createBanner($title, $skin)
    {
        return app('xe.banner')->createGroup([
            'title' => $title,
            'skin' => $skin
        ]);
    }

    /**
     * @param $banner
     * @param $contents array
     */
    public function storeBannerItem($banner, $contents)
    {
        foreach ($contents as $content) {
            app('xe.banner')->createItem($banner, $content);
        }
    }

    private function storeImage($path, $name)
    {
        $file = file_get_contents($path);
        $imgFile = \XeStorage::create($file, 'public/together/widget/sample', $name);
        $image = \XeMedia::make($imgFile);

        return [
            'id' => $imgFile->id,
            'filename' => $imgFile->clientname,
            'path' => $image->url()
        ];
    }

    public function settingWidgetpage($widgetpageId, $boardIds)
    {
        $categoryBanner = $this->createBanner('카테고리 배너', CategorySkin::getId());
        $this->storeBannerItem($categoryBanner, $this->getCategoryBannerContents());

        $ddayBanner = $this->createBanner('디데이 배너', DdaySkin::getId());
        $this->storeBannerItem($ddayBanner, $this->getDdayBannerContents());

        $mediaWidget = [
            'board_id' => $boardIds['blog'],
            'take' => '2',
            'recent_date' => 0,
            'order_type' => '',
            '@attributes' => [
                'id' => ArticleListWidget::getId(),
                'title' => '미디어 위젯',
                'skin-id' => MediaSkin::getId()
            ]
        ];

        $categoryBannerWidget = [
            'group_id' => $categoryBanner->id,
            '@attributes' => [
                'id' => Widget::getId(),
                'title' => '카테고리 배너 위젯',
                'skin-id' => CategorySkin::getId()
            ]
        ];

        $ddayBannerWidget = [
            'group_id' => $ddayBanner->id,
            '@attributes' => [
                'id' => Widget::getId(),
                'title' => '디데이 배너 위젯',
                'skin-id' => DdaySkin::getId()
            ]
        ];

        $boardWidget = [
            'board_id' => $boardIds['board'],
            'take' => '4',
            'recent_date' => 0,
            'order_type' => '',
            '@attributes' => [
                'id' => ArticleListWidget::getId(),
                'title' => '최신글 위젯',
                'skin-id' => LatestSkin::getId()
            ]
        ];

        $noticeWidget = [
            'board_id' => $boardIds['notice'],
            'take' => '2',
            'recent_date' => 0,
            'order_type' => '',
            '@attributes' => [
                'id' => ArticleListWidget::getId(),
                'title' => 'NOTICE',
                'skin-id' => NoticeSkin::getId()
            ]
        ];

        $galleryWidget = [
            'board_id' => $boardIds['gallery'],
            'take' => '6',
            'recent_date' => 0,
            'order_type' => '',
            '@attributes' => [
                'id' => ArticleListWidget::getId(),
                'title' => 'Gallery',
                'skin-id' => GallerySkin::getId()
            ]
        ];

        app('xe.widgetbox')->update('widgetpage-' . $widgetpageId, ['content' => [
            [
                [
                    'grid' => [
                        'md' => '12'
                    ],
                    'rows' => [],
                    'widgets' => [
                        $mediaWidget
                    ]
                ]
            ],

            [
                [
                    'grid' => [
                        'md' => '12'
                    ],
                    'rows' => [],
                    'widgets' => [
                        $categoryBannerWidget
                    ]
                ]
            ],
            [
                [
                    'grid' => [
                        'md' => '9'
                    ],
                    'rows' => [],
                    'widgets' => [
                        $ddayBannerWidget
                    ]
                ],
                [
                    'grid' => [
                        'md' => '3'
                    ],
                    'rows' => [],
                    'widgets' => [
                        $boardWidget
                    ]
                ]
            ],
            [
                [
                    'grid' => [
                        'md' => '12'
                    ],
                    'rows' => [],
                    'widgets' => [
                        $noticeWidget
                    ]
                ]
            ],

            [
                [
                    'grid' => [
                        'md' => '12'
                    ],
                    'rows' => [],
                    'widgets' => [
                        $galleryWidget
                    ]
                ]
            ]
        ]]);
    }

    /**
     * @return array
     */
    private function getCategoryBannerContents()
    {
        $imageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/banner1.jpg'), 'banner1.jpg');
        $contents[] = [
            'status' => 'show',
            'title' => '홈 화면 변경하기',
            'content' => '사이트 홈을 설정해보세요',
            'link' => '/blog/홈-화면-변경하기',
            'image' => $imageInfo,
            'link_target' => '_blank'
        ];

        $imageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/banner2.jpg'), 'banner2.jpg');
        $contents[] = [
            'status' => 'show',
            'title' => '메뉴 구조 구성하기',
            'content' => '메뉴를 만들어 보세요',
            'link' => '/blog/메뉴-구조-구성하기',
            'image' => $imageInfo,
            'link_target' => '_blank'
        ];

        $imageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/banner3.jpg'), 'banner3.jpg');
        $contents[] = [
            'status' => 'show',
            'title' => '테마 디자인 변경하기',
            'content' => '다른 테마로 변경해보세요',
            'link' => '/blog/테마-디자인-변경하기',
            'image' => $imageInfo,
            'link_target' => '_blank'
        ];

        $imageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/banner4.jpg'), 'banner4.jpg');
        $contents[] = [
            'status' => 'show',
            'title' => '플러그인 관리하기',
            'content' => '새로운 플러그인을 설치해보세요',
            'link' => '/blog/플러그인-관리하기',
            'image' => $imageInfo,
            'link_target' => '_blank'
        ];

        return $contents;
    }

    private function getDdayBannerContents()
    {
        $imageInfo = $this->storeImage(Plugin::path('assets/images/demo_images/dday.jpg'), 'dday.jpg');
        $contents[] = [
            'status' => 'show',
            'title' => 'XE Store Beta Open',
            'content' => 'XE의 멋진 익스텐션과 테마를 만나보세요!' . PHP_EOL . '마음에 드는 플러그인을 골라 웹사이트의 기능을 확장하고 아름답게 꾸며보세요!',
            'link' => 'https://store.xehub.io',
            'image' => $imageInfo,
            'link_target' => '_blank',
            'etc' => ['dday_at' => '2019-02-27']
        ];

        return $contents;
    }
}
