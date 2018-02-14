<?php
/**
 * DefaultParts.php
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

use Illuminate\Support\Arr;

class DefaultPart extends RegisterFormPart
{
    const ID = 'default-info';

    const NAME = '기본정보';

    const DESCRIPTION = '기본정보(이메일, 이름, 비밀번호) 입력 폼입니다.';

    protected static $implicit = true;

    protected static $view = 'register.forms.default';

    protected function data()
    {
        $passwordConfig = $this->service('config')->get('xe.user.password');
        $passwordLevel = Arr::get($passwordConfig['levels'], $passwordConfig['default']);

        return compact('passwordLevel');
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'display_name' => 'required',
            'password' => 'required|confirmed|password',
        ];
    }
}
