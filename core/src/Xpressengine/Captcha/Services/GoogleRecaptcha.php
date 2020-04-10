<?php
/**
 * This file is google reCAPTCHA.
 *
 * PHP version 7
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Captcha\Services;

use Illuminate\Http\Request;
use ReCaptcha\ReCaptcha;
use ReCaptcha\Response;
use Xpressengine\Captcha\CaptchaInterface;
use Xpressengine\Presenter\Html\FrontendHandler;

/**
 * 구글 reCAPTCHA 기능을 처리 함.
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class GoogleRecaptcha implements CaptchaInterface
{
    /**
     * ReCaptcha instance
     *
     * @var ReCaptcha
     */
    protected $captcha = null;

    /**
     * Http Request instance
     *
     * @var Request
     */
    protected $request;

    /**
     * Api site key
     *
     * @var string
     */
    protected $siteKey;

    /**
     * Api secret key
     *
     * @var string
     */
    protected $secret;

    /**
     * FrontendHandler instance
     *
     * @var FrontendHandler
     */
    protected $frontend;

    /**
     * ReCaptcha response instnace
     *
     * @var Response
     */
    protected $response;

    /**
     * Captcha input name
     *
     * @var string
     */
    protected $input = 'g-recaptcha-response';

    /**
     * Constructor
     *
     * @param string          $siteKey  Api site key
     * @param string          $secret   Api secret key
     * @param Request         $request  Http Request instance
     * @param FrontendHandler $frontend FrontendHandler instance
     */
    public function __construct($siteKey, $secret, Request $request, FrontendHandler $frontend)
    {
        $this->siteKey = $siteKey;
        $this->secret = $secret;
        $this->request = $request;
        $this->frontend = $frontend;
    }

    /**
     * Verify captcha
     *
     * @return bool
     */
    public function verify()
    {
        $this->create();

        if ($this->response === null) {
            $this->response = $this->captcha->setExpectedHostname($this->request->getHost())
                ->verify($this->request->get($this->input), $this->request->ip());
        }

        return $this->response->isSuccess();
    }

    /**
     * Message of fails
     *
     * @return array
     */
    public function errors()
    {
        return $this->response->getErrorCodes();
    }

    /**
     * For UI object display
     *
     * @return string
     */
    public function render()
    {
        $this->frontend->js('https://www.google.com/recaptcha/api.js')->appendTo('head')->load();

        return '<div class="g-recaptcha" data-sitekey="' . $this->siteKey . '"></div>';
    }

    /**
     * Captcha input name
     *
     * @return string
     */
    public function getInputName()
    {
        return $this->input;
    }

    /**
     * Create captcha instance
     *
     * @return ReCaptcha
     */
    protected function create()
    {
        if ($this->captcha === null) {
            $this->captcha = new ReCaptcha($this->secret);
        }

        return $this->captcha;
    }

    /**
     * Determine if captcha is available
     *
     * @return mixed
     */
    public function available()
    {
        try {
            $this->create();
        } catch (\Exception $e) {
            return false;
        }

        return true;
    }
}
