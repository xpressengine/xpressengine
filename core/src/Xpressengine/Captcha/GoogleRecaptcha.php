<?php
/**
 * This file is google reCAPTCHA.
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     LGPL-2.1
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Captcha;

use Illuminate\Http\Request;
use ReCaptcha\ReCaptcha;
use ReCaptcha\Response;
use Xpressengine\Presenter\Html\FrontendHandler;

/**
 * 구글 reCAPTCHA 기능을 처리 함.
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 */
class GoogleRecaptcha implements CaptchaInterface
{
    /**
     * ReCaptcha instance
     *
     * @var ReCaptcha
     */
    protected $captcha;

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

        $this->captcha = $this->create($this->secret);
    }

    /**
     * Verify captcha
     *
     * @return bool
     */
    public function verify()
    {
        if ($this->response === null) {
            $this->response = $this->captcha->verify($this->request->get($this->input), $this->request->ip());
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
     * @param string $secret Api secret key
     * @return ReCaptcha
     */
    protected function create($secret)
    {
        return new ReCaptcha($secret);
    }
}
