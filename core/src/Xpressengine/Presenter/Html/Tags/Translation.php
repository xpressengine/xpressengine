<?php
/**
 * Translation
 *
 * PHP version 7
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Presenter\Html\Tags;

use XeLang;

/**
 * Translation
 * > Translation은 instance가 없음
 *
 * ## 사용법
 *
 * ### front에 다국어 설정
 * * XeFrontend::translation([]);
 * * XeFrontend::output('translation');
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class Translation
{
    use AttributeTrait;
    use MinifyTrait;
    use TargetTrait;
    use EmptyStringTrait;

    /**
     * @var array
     */
    protected static $keys = [];

    /**
     * output
     *
     * @return string
     */
    public static function output()
    {
        $locales = [];
        $terms = [];

        foreach (XeLang::getLocales() as $code) {
            $locales[] = [
                'code' => $code,
                'nativeName' => XeLang::getLocaleText($code)
            ];
        }

        foreach (self::$keys as $key => $null) {
            $line = XeLang::getOriginalLine($key);
            if ($line) {
                $terms[$key] = $line;
            }
        }
        self::$keys = $terms;

        return json_enc(compact('locales', 'terms'));
    }

    /**
     * add key
     *
     * @param string $key key
     *
     * @return void
     */
    private static function addKey($key)
    {
        self::$keys[$key] = null;
    }

    /**
     * add keys
     *
     * @param array $keys keys
     *
     * @return void
     */
    private static function addKeys(array $keys)
    {
        self::$keys = array_merge(self::$keys, array_fill_keys($keys, null));
    }

    /**
     * init
     *
     * @return void
     */
    public static function init()
    {
    }


    /**
     * translations
     *
     * @return array
     */
    public static function getTransList()
    {
        $newKeys = [];
        foreach (self::$keys as $key => $null) {
            $line = XeLang::getOriginalLine($key);
            if ($line) {
                $newKeys[$key] = $line;
            }
        }

        return $newKeys;
    }

    /**
     * create instance
     *
     * @param array|string $keys key
     */
    public function __construct($keys)
    {
        if (is_string($keys)) {
            self::addKey($keys);
        } elseif (is_array($keys)) {
            self::addKeys($keys);
        }
    }
}
