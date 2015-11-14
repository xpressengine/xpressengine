<?php
/**
 * This file is captcha UI object.
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
namespace Xpressengine\UIObjects\Captcha;

use Xpressengine\Captcha\CaptchaManager;
use Xpressengine\UIObject\AbstractUIObject;

/**
 * client 에 표현되어질 ui 제공을 담당 함.
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class CaptchaUIObject extends AbstractUIObject
{
    /**
     * Component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@captcha';

    /**
     * CaptchaManager instance
     *
     * @var CaptchaManager
     */
    protected static $manager;

    /**
     * To do on boot
     *
     * @return void
     */
    public static function boot()
    {
        // nothing to do
    }

    /**
     * Url for component management
     *
     * @return void
     */
    public static function getSettingsURI()
    {
        // nothing to do
    }

    /**
     * Rendered current object
     *
     * @return string
     */
    public function render()
    {
        $driver = isset($this->arguments['driver']) ? $this->arguments['driver'] : static::$manager->getDefaultDriver();
        $this->template = static::$manager->driver($driver)->render();

        return parent::render();
    }

    /**
     * Set manager instance
     *
     * @param CaptchaManager $manager CaptchaManager instance
     * @return void
     */
    public static function setManager(CaptchaManager $manager)
    {
        static::$manager = $manager;
    }
}
