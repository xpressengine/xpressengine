<?php
/**
 * ConfigurationNotExistsException class
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

namespace Xpressengine\Captcha\Exceptions;

use Xpressengine\Captcha\CaptchaException;

/**
 * 캡차 설정이 되어있지 않은 경우 발생하는 예외
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class ConfigurationNotExistsException extends CaptchaException
{
    protected $message = '캡차 설정이 되어있지 않습니다. 설정파일(config/captcha.php)을 확인하십시오.';
}
