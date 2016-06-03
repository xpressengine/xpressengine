<?php
/**
 * Class Translation
 *
 * @category    Translation
 * @package     Xpressengine\Translation
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

if (! function_exists('xe_trans')) {
    /**
     * @param null   $id         다국어 키
     * @param array  $parameters 파라매터
     * @param string $domain     domain
     * @param null   $locale     로케일
     * @return string
     */
    function xe_trans($id = null, $parameters = array(), $domain = 'messages', $locale = null)
    {
        if (is_null($id)) {
            return app('xe.translator');
        }

        try {
            return app('xe.translator')->trans($id, $parameters, $domain, $locale);
        } catch (Exception $e) {
            return $id;
        }
    }
}

if (! function_exists('xe_trans_choice')) {
    /**
     * @param string $id         다국어 키
     * @param int    $number     숫자
     * @param array  $parameters 파라매터
     * @param string $domain     domain
     * @param null   $locale     로케일
     * @return string
     */
    function xe_trans_choice($id, $number, array $parameters = array(), $domain = 'messages', $locale = null)
    {
        return app('xe.translator')->transChoice($id, $number, $parameters, $domain, $locale);
    }
}
