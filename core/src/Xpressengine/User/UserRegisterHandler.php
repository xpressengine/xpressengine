<?php
/**
 * UserRegisterHandler.php
 *
 * PHP version 7
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
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
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class UserRegisterHandler
{
    protected $config;

    const TERM_AGREE_PRE = 'pre';
    const TERM_AGREE_WITH = 'with';
    const TERM_AGREE_NOT = 'not';

    public function __construct()
    {
        $this->config = app('xe.config')->get('user.register');
    }

    public function updateConfig($attribute)
    {
        if (isset($attribute['joinable']) && $attribute['joinable'] === 'true') {
            $attribute['joinable'] = true;
        } else {
            $attribute['joinable'] = false;
        }

        foreach ($attribute as $key => $value) {
            $this->config->set($key, $value);
        }

        app('xe.config')->modify($this->config);
    }
}
