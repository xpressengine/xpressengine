<?php
/**
 * CaptchaPart.php
 *
 * PHP version 5
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Parts;

/**
 * Class CaptchaPart
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class CaptchaPart extends RegisterFormPart
{
    const ID = 'captcha';

    const NAME = '캡차';

    const DESCRIPTION = '캡차 문자 입력 폼입니다.';

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
     * Validate the request with the form part rules.
     *
     * @return array
     */
    public function validate()
    {
        $this->getValidationFactory()->extendImplicit('captcha', function () {
            return $this->service('xe.captcha')->verify() === true;
        }, '자동인증방지 기능을 통과하지 못하였습니다.');
        $this->traitValidate($this->request, ['CaptchaParts' => 'captcha']);

        return [];
    }
}
