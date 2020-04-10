<?php
/**
 * DefaultPart.php
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
 * Class DefaultPart
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DefaultPart extends RegisterFormPart
{
    const ID = 'default-info';

    const NAME = 'xe::defaultInfo';

    const DESCRIPTION = 'xe::descDefaultInfo';

    /**
     * Indicates if the form part is implicit
     *
     * @var bool
     */
    protected static $implicit = true;

    /**
     * The view for the form part
     *
     * @var string
     */
    protected static $view = 'register.forms.new_default';

    /**
     * Get validation rules of the form part
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'email' => 'required|email',
            'login_id' => 'required|login_id',
            'password' => 'required|password',
        ];

        if (app('xe.config')->getVal('user.register.use_display_name') === true) {
            $rules['display_name'] = 'required';
        }

        return $rules;
    }

    /**
     * validate
     * 기존에 존재하는 스킨에 비밀번호 확인 필드가 있는 경우를 대비해서 유효성 검사 조건 추가
     *
     * @return void
     */
    public function validate()
    {
        $rules = $this->rules();

        if ($this->request->has('password_confirmation') === true) {
            $rules['password'] .= '|confirmed';
        }

        $this->traitValidate($this->request, $rules);
    }
}
