<?php
/**
 * This file is captcha interface.
 *
 * PHP version 7
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Captcha;

/**
 * captcha 기능을 제공하기 위한 인터페이스를 정의함.
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
