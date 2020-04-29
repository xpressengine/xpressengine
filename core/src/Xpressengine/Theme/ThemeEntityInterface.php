<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Theme
 * @package     Xpressengine\Theme
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Theme;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Xpressengine\Config\ConfigEntity;

/**
 * ThemeEntity는 하나의 테마에 대한 정보를 가지고 있는 클래스이다.
 * XpressEngine에 등록된 테마들의 정보를 ThemeEntity로 생성하여 처리한다.
 *
 * @category    Theme
 * @package     Xpressengine\Theme
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
interface ThemeEntityInterface extends Arrayable, Jsonable
{
    /**
     * get theme id
     *
     * @return string
     */
    public function getId();

    /**
     * get theme title
     *
     * @return mixed
     */
    public function getTitle();

    /**
     * get theme's description
     *
     * @return string
     */
    public function getDescription();

    /**
     * get screenshot of theme
     *
     * @return mixed
     */
    public function getScreenshot();

    /**
     * 테마가 desktop 버전을 지원하는지 조사한다.
     *
     * @return bool desktop 버전을 지원할 경우 true
     */
    public function supportDesktop();

    /**
     * 테마가 mobile 버전을 지원하는지 조사한다.
     *
     * @return bool mobile 버전을 지원할 경우 true
     */
    public function supportMobile();

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render();

    /**
     * return editConfigView
     *
     * @param ConfigEntity $config config data
     *
     * @return \Illuminate\Contracts\View\View|void
     */
    public function renderSetting(ConfigEntity $config = null);

    /**
     * updateConfig
     *
     * @param array $config pure config data
     *
     * @return array
     */
    public function resolveSetting(array $config);

    /**
     * get and set config
     *
     * @param ConfigEntity $config config data
     *
     * @return null
     */
    public function setting(ConfigEntity $config = null);
}
