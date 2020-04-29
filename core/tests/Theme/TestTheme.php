<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Theme;

use Xpressengine\Config\ConfigEntity;
use Xpressengine\Theme\AbstractTheme;

class TestTheme extends AbstractTheme
{
    protected static $id = 'theme/test@theme';
    protected static $supportDesktop = false;
    protected static $supportMobile = true;

    protected static $componentInfo = [
        'name' => 'Test Theme',
        'description' => 'blur~~ blur~~',
        'screenshot' => 'screenshot',
    ];

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
    }

    public function getEditFiles()
    {
        return ['foo'];
    }

    /**
     * return settings manage uri
     *
     * @return null|string
     */
    public static function getSettingsURI()
    {
        return 'http://foo.bar';
    }

    /**
     * 테마 설정 페이지에 출력할 html 텍스트를 출력한다.
     * 설정폼은 자동으로 생성되며 설정폼 내부에 출력할 html만 반환하면 된다.
     *
     * @param ConfigEntity|null $config 기존에 설정된 설정값
     *
     * @return string
     */
    public function getSettingView(ConfigEntity $config = null)
    {
    }
}
