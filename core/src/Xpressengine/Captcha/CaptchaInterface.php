<?php
/**
 * This file is captcha interface.
 *
 * PHP version 5
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Captcha;

/**
 * captcha 기능을 제공하기 위한 인터페이스를 정의함.
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
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
     * Determine if captcha is available
     *
     * @return mixed
     */
    public function available();

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
