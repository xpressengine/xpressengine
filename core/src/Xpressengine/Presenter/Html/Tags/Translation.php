<?php
/**
 * Translation
 *
 * PHP version 5
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Presenter\Html\Tags;

use XeLang;

/**
 * Translation
 * > Translation 은 다른 tag 들과 달리 instance 가 필요 없음
 *
 * ## 사용법
 *
 * ### front 에 다국어 설정
 * * XeFrontend::translation([]);
 * * XeFrontend::output('translation');
 *
 * @category    Frontend
 * @package     Xpressengine\Presenter
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Translation
{
    use AttributeTrait;
    use MinifyTrait;
    use SortTrait;
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
        $newKeys = [];
        foreach (self::$keys as $key => $null) {
            $line = XeLang::getOriginalLine($key);
            if ($line) {
                $newKeys[$key] = $line;
            }
        }
        self::$keys = $newKeys;

        $output = '<script>';
        $output .= sprintf(
            'XE.Lang.setLocales(%s);'.
            'XE.Lang.set(%s);',
            json_enc(XeLang::getLocales()),
            json_enc(self::$keys)
        );
        $output .= '</script>';

        return $output;
    }

    /**
     * add key
     *
     * @param string $key key
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
