<?php
/**
 * CaptchaPart.php
 *
 * PHP version 7
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Parts;

/**
 * Class CaptchaPart
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class CaptchaPart extends RegisterFormPart
{
    const ID = 'captcha';

    const NAME = 'CAPTCHA';

    const DESCRIPTION = 'xe::descCaptcha';

    /**
     * Get the html string of the form part
     *
     * @return \Illuminate\Support\HtmlString|string
     */
    public function render()
    {
        return $this->service('xe.uiobject')->create('captcha')->render();
    }

    /**
     * 동적으로 상태를 확인해서 사용 가능 한 part인지 반환
     *
     * @return bool
     */
    public static function isAvailable()
    {
        return app('xe.captcha')->available();
    }

    /**
     * Validate the request with the form part rules.
     *
     * @return array
     */
    public function validate()
    {
        if (self::isAvailable() === false) {
            return [];
        }

        $this->getValidationFactory()->extendImplicit('captcha', function () {
            return $this->service('xe.captcha')->verify() === true;
        }, $this->service('xe.translator')->trans('xe::msgFailToPassCAPTCHA'));
        $this->traitValidate($this->request, ['CaptchaParts' => 'captcha']);

        return [];
    }
}
