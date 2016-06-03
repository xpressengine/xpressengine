<?php
/**
 * This file is captcha interface.
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Captcha;

/**
 * captcha 기능을 제공하기 위한 인터페이스를 정의함.
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
interface CaptchaInterface
{
    /**
     * Verify captcha
     *
     * @return bool
     */
    public function verify();

    /**
     * Message of fails
     *
     * @return array
     */
    public function errors();

    /**
     * For UI object display
     *
     * @return string
     */
    public function render();

    /**
     * Captcha input name
     *
     * @return string
     */
    public function getInputName();
}
