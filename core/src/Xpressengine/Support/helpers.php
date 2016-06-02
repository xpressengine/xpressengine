<?php
/**
 * This file is support helper functions
 *
 * PHP version 5
 *
 * @category    Support
 * @package     Xpressengine\Support
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

if (function_exists('json_enc') === false) {
    /**
     * Returns the JSON representation of a value
     *
     * @param mixed $value   target for encoding
     * @param int   $options json behavior constant
     * @param int   $depth   maximum depth
     * @return string
     */
    function json_enc($value, $options = 0, $depth = 512)
    {
        return Xpressengine\Support\Json::encode($value, $options, $depth);
    }
}

if (function_exists('json_dec') === false) {
    /**
     * Decodes a JSON string
     *
     * @param string $string  target for decoding
     * @param bool   $assoc   when true, object be converted to array
     * @param int    $depth   recursion depth
     * @param int    $options decode option, just support 'JSON_BIGINT_AS_STRING'
     * @return mixed
     */
    function json_dec($string, $assoc = false, $depth = 512, $options = 0)
    {
        return Xpressengine\Support\Json::decode($string, $assoc, $depth, $options);
    }
}

if (function_exists('cast') === false) {
    /**
     * scalar 타입 문자열을 실제 형태로 형변환
     *
     * '1' -> 1, '1.0001' -> 1.0001, 'true' -> true
     *
     * @param string $value 대상 문자열
     * @return mixed
     */
    function cast($value)
    {
        return Xpressengine\Support\Caster::cast($value);
    }
}


if (function_exists('bytes') === false) {
    /**
     * 파일 용량을 보기 좋은 형태로 변환
     *
     * @param int         $bytes bytes 수치
     * @param null|string $unit  표현 단위
     * @param int         $dec   소수점 이하 표현 갯수
     * @return string
     */
    function bytes($bytes, $unit = null, $dec = 2)
    {
        $size   = ['B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
        if (in_array($unit, $size)) {
            $factor = array_search($unit, $size);
        } else {
            $factor = (int)((strlen($bytes) - 1) / 3);
        }
        $dec = $factor == 0 ? 0 : $dec;
        if ($factor >= count($size)) {
            $factor = count($size) - 1;
        }

        return sprintf("%.{$dec}f", $bytes / pow(1024, $factor)) . $size[$factor];
    }
}

if (function_exists('apiRender') === false) {
    /**
     * XE.page() 를 사용하여 호출할 경우 render 된 html 반환
     *
     * @param string $id   view id
     * @param array  $data data
     * @return mixed
     */
    function apiRender($id, array $data = [])
    {
        XePresenter::htmlRenderPartial();

        XePresenter::setId($id);
        XePresenter::setData($data);

        /** @var Xpressengine\Presenter\Html\HtmlRenderer $renderer */
        $renderer = XePresenter::getRenderer('html');
        $renderer->setData();
        $result = $renderer->renderSkin();

        return XePresenter::makeApi([
            'result' => (string)$result,
            'XE_ASSET_LOAD' => [
                'css' => [],
                'js' => [],
            ],
        ]);
    }
}
