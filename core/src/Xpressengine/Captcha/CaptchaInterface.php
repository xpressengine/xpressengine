<?php
/**
 * This file is captcha interface.
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Captcha;

/**
 * captcha 기능을 제공하기 위한 인터페이스를 정의함.
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
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
