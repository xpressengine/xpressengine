<?php
/**
 * UIObject function. This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    UIObject
 * @package     Xpressengine\UIObject
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */

if (function_exists('uio') === false) {
    /**
     * 주어진 타입의 AbstractUIObject 인스턴스를 생성하여 반환한다.
     *
     * @param string $id       UIObject의 id, 또는 alias
     * @param mixed  $args     UIObject를 생성할 때 전달할 argument
     * @param null   $callback UIObject의 출력을 변경하려고 할 때 사용된다. 만약 callback이 지정돼 있으면 UIObject가 출력될 때,
     *                         callback을 한번 실행후 출력한다.
     *                         이 때 callback은 파라메터로 출력될 html의 PhpQueryObject 인스턴스를 전달받는다.
     *                         ```php
     *                         uio('phone', $data, function(PhpQueryObject $markup) {
     *                         $firstNum = $markup['input:first'];
     *                         $firstNum->val('010');
     *                         }
     *                         ```
     *
     * @return \Xpressengine\UIObject\AbstractUIObject 생성된 AbstractUIObject
     */
    function uio($id, $args = [], $callback = null)
    {
        return \XeUI::create($id, $args, $callback)->render();
    }
}
