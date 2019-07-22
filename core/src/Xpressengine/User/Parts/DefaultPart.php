<?php
/**
 * DefaultPart.php
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

namespace Xpressengine\User\Parts;

/**
 * Class DefaultPart
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2019 Copyright XEHub Corp. <https://www.xehub.io>
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
    protected static $view = 'register.forms.default';

    /**
     * Get validation rules of the form part
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email',
            'display_name' => 'required',
            'password' => 'required|confirmed|password',
        ];
    }
}
