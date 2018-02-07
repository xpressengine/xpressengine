<?php
/**
 * AgreementParts.php
 *
 * PHP version 5
 *
 * @category
 * @package
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\User\Parts;

class AgreementParts extends RegisterFormParts
{
    protected static $name = '이용약관 동의';

    protected static $description = '이용약관 동의 체크박스입니다.';

    protected static $implicit = true;

    protected static $view = 'register.forms.agreements';

    protected function data()
    {
        $terms = $this->service('xe.terms')->fetchEnabled();

        return compact('terms');
    }

    public function rules()
    {
        return ['agree' => 'accepted'];
    }
}
