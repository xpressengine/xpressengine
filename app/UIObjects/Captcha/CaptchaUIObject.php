<?php
/**
 * CaptchaUIObject.php
 *
 * PHP version 7
 *
 * @category    UIObjects
 * @package     App\UIObjects\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\UIObjects\Captcha;

use Xpressengine\UIObject\AbstractUIObject;

/**
 * Class CaptchaUIObject
 *
 * @category    UIObjects
 * @package     App\UIObjects\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class CaptchaUIObject extends AbstractUIObject
{
    /**
     * The component id
     *
     * @var string
     */
    protected static $id = 'uiobject/xpressengine@captcha';

    /**
     * Get the evaluated contents of the object.
     *
     * @return string
     */
    public function render()
    {
        $driver = $this->arguments['driver'] ?? null;
        $this->template = app('xe.captcha')->driver($driver)->render();

        return parent::render();
    }
}
