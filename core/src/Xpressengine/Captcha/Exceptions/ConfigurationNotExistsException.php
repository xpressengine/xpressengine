<?php
/**
 * ConfigurationNotExistsException class
 *
 * PHP version 5
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Captcha\Exceptions;

use Xpressengine\Captcha\CaptchaException;

/**
 * 캡차 설정이 되어있지 않은 경우 발생하는 예외
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class ConfigurationNotExistsException extends CaptchaException
{
    protected $message = '캡차 설정이 되어있지 않습니다. 설정파일(config/captcha.php)을 확인하십시오.';
}
