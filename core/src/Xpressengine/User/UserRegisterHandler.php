<?php
/**
 * UserRegisterHandler.php
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

namespace Xpressengine\User;

/**
 * Class UserRegisterHandler
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UserRegisterHandler
{
    protected $config;

    const TERM_AGREE_PRE = 'pre';
    const TERM_AGREE_WITH = 'with';
    const TERM_AGREE_NOT = 'not';

    /**
     * UserRegisterHandler constructor.
     */
    public function __construct()
    {
        $this->config = app('xe.config')->get('user.register');
    }

    /**
     * update user register config
     *
     * @param array $attribute attribute
     *
     * @return void
     */
    public function updateConfig($attribute)
    {
        $attribute['joinable'] = isset($attribute['joinable']);
        $attribute['display_name_unique'] = isset($attribute['display_name_unique']);
        $attribute['use_display_name'] = isset($attribute['use_display_name']);
        $attribute['use_login_id'] = isset($attribute['use_login_id']);
        $attribute['use_password_confirm'] = isset($attribute['use_password_confirm']);

        $attribute['forms'] = array_keys(array_get($attribute, 'forms', []));
        $attribute['dynamic_fields'] = array_keys(array_get($attribute, 'dynamic_fields', []));

        $passwordRules = '';
        foreach ($attribute['password_rules'] as $rule => $value) {
            if ($rule === 'min') {
                $rule .= ':' . $value;
            }

            $passwordRules .= $rule . '|';
        }
        $attribute['password_rules'] = rtrim($passwordRules, '|');

        foreach ($attribute as $key => $value) {
            $this->config->set($key, $value);
        }

        app('xe.config')->modify($this->config);
    }
}
