<?php
/**
 * EmailVerifyPart.php
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

use Symfony\Component\HttpKernel\Exception\HttpException;
use Xpressengine\Http\Request;

/**
 * Class EmailVerifyPart
 *
 * @category    User
 * @package     Xpressengine\User
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class EmailVerifyPart extends RegisterFormPart
{
    const ID = 'email';

    const NAME = 'xe::emailConfirmationCode';

    const DESCRIPTION = 'xe::descEmailConfirmationCode';

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
    protected static $view = 'register.forms.confirm';

    /**
     * RegisterFormPart constructor.
     *
     * @param Request $request request instance
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->addListener();
    }

    /**
     * Get the html string of the form part
     *
     * @return \Illuminate\Support\HtmlString|string
     */
    public function render()
    {
        return $this->isEnabled() ? parent::render() : '';
    }

    /**
     * Get data for form part view
     *
     * @return array
     */
    protected function data()
    {
        if (!$token = $this->getToken($this->request->get('token'))) {
            throw new HttpException(400, $this->service('xe.translator')->trans('xe::msgTokenIsInvalid'));
        }

        $code = $this->request->get('code');

        return compact('token', 'code');
    }

    /**
     * Get validation rules of the form part
     *
     * @return array
     */
    public function rules()
    {
        return $this->isEnabled() ? ['register_token' => 'required', 'code' => 'required'] : [];
    }

    /**
     * Validate the request with the form part rules.
     *
     * @return array
     */
    public function validate()
    {
        parent::validate();

        $returns = [];
        if ($this->isEnabled()) {
            $lang = $this->service('xe.translator');
            if (!$token = $this->getToken($this->request->get('register_token'))) {
                throw new HttpException(400, $lang->trans('xe::msgUnknownTokenForSignUp'));
            }

            $this->getValidationFactory()->extend('email_verify', function ($attr, $value) use ($token) {
                return $this->verify($token->email, $value);
            }, $lang->trans('xe::invalidConfirmationCode'));
            $this->traitValidate($this->request, ['code' => 'required|email_verify']);

            $returns['id'] = $this->getEmail($token->email)->user_id;
        }

        return $returns;
    }

    /**
     * Get a token for register
     *
     * @param string $id id
     * @return mixed
     */
    protected function getToken($id)
    {
        return $id ? $this->getTokenRepo()->find($id) : null;
    }

    /**
     * Determine if the form part was enabled
     *
     * @return boolean
     */
    protected function isEnabled()
    {
        return $this->service('xe.config')->get('user.join')->get('guard_forced', false);
    }

    /**
     * Determine if the given address and code is available
     *
     * @param string $address email address
     * @param string $code    code for verify
     * @return bool
     */
    protected function verify($address, $code)
    {
        return $this->getEmail($address)->getConfirmationCode() === $code;
    }

    /**
     * Get the email object for the given address
     *
     * @param string $address email address
     * @return \Xpressengine\User\Models\UserEmail|null
     */
    protected function getEmail($address)
    {
        return $this->service('xe.user')->pendingEmails()->findByAddress($address);
    }

    /**
     * Register the event listener
     *
     * @return void
     */
    protected function addListener()
    {
        intercept('XeUser@create', 'delete_token', function ($method, $data) {
            $user = $method($data);

            if ($id = $this->request->get('register_token')) {
                $this->getTokenRepo()->delete($id);
            }

            return $user;
        });
    }

    /**
     * Get the token repository
     *
     * @return \Xpressengine\User\Repositories\RegisterTokenRepository
     */
    protected function getTokenRepo()
    {
        return $this->service('xe.user.register.tokens');
    }
}
