<?php
/**
 * This file is captcha UI object.
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

namespace App\UIObjects\Captcha;

use Xpressengine\Captcha\CaptchaManager;
use Xpressengine\UIObject\AbstractUIObject;

/**
 * client 에 표현되어질 ui 제공을 담당 함.
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
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
