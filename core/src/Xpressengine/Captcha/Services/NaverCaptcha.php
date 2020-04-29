<?php
/**
 * NaverCaptcha.php
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
use GuzzleHttp\Client;
use Xpressengine\Captcha\CaptchaInterface;
use Illuminate\View\Factory as View;
use Xpressengine\Captcha\Exceptions\WrongResponseException;
use Xpressengine\Presenter\Html\FrontendHandler;

/**
 * Class NaverCaptcha
 *
 * @category    Captcha
 * @package     Xpressengine\Captcha
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class NaverCaptcha implements CaptchaInterface
{
    /**
     * Api client id
     *
     * @var string
     */
    protected $clientId;

    /**
     * Api client secret
     *
     * @var string
     */
    protected $clientSecret;

    /**
     * Http Request instance
     *
     * @var Request
     */
    protected $request;

    /**
     * FrontendHandler instance
     *
     * @var FrontendHandler
     */
    protected $frontend;

    /**
     * View Factory instance
     *
     * @var View
     */
    protected $view;

    /**
     * Api request timeout
     *
     * @var int
     */
    protected $timeout;

    /**
     * Request url prefix
     *
     * @var string
     */
    protected $urlPrefix = 'https://openapi.naver.com/v1/captcha/';

    /**
     * Error messages
     *
     * @var array
     */
    protected $errors = [];

    /**
     * NaverCaptcha constructor.
     *
     * @param string          $clientId     Api client id
     * @param string          $clientSecret Api client secret
     * @param Request         $request      Http Request instance
     * @param FrontendHandler $frontend     FrontendHandler instance
     * @param View            $view         View Factory instance
     * @param int             $timeout      Api request timeout
     */
    public function __construct(
        $clientId,
        $clientSecret,
        Request $request,
        FrontendHandler $frontend,
        View $view,
        $timeout = 0
    ) {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->request = $request;
        $this->frontend = $frontend;
        $this->view = $view;
        $this->timeout = $timeout;
    }

    /**
     * Verify captcha
     *
     * @return bool
     */
    public function verify()
    {
        $client = $this->createClient();
        $uri = 'nkey?' . http_build_query([
                'code' => 1,
                'value' => $this->request->get($this->getInputName()),
                'key' => $this->request->get('key')
            ]);
        try {
            $response = $client->request('get', $uri, [
                'headers' => [
                    'X-Naver-Client-Id' => $this->clientId,
                    'X-Naver-Client-Secret' => $this->clientSecret
                ],
            ]);
            $content = json_dec($response->getBody()->getContents(), true);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            $response = $e->getResponse();
            $content = json_dec($response->getBody()->getContents(), true);
            $this->errors[array_get($content, 'errorCode')] = array_get($content, 'errorMessage');
        }

        $result = array_get($content, 'result');

        return $result === true;
    }

    /**
     * Determine if captcha is available
     *
     * @return mixed
     */
    public function available()
    {
        if ($this->clientId == null || $this->clientSecret == null) {
            return false;
        }

        return true;
    }

    /**
     * Message of fails
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * For UI object display
     *
     * @return string
     */
    public function render()
    {
        $key = $this->issue();

        return $this->view->make('captcha.naver', [
            'key' => $key,
            'img' => $this->getImgSrc($key),
            'name' => $this->getInputName()
        ])->render();
    }

    /**
     * Issued the captcha key
     *
     * @return string
     * @throws WrongResponseException
     */
    public function issue()
    {
        $client = $this->createClient();

        $response = $client->request('get', 'nkey?' . http_build_query(['code' => 0]), [
            'headers' => [
                'X-Naver-Client-Id' => $this->clientId,
                'X-Naver-Client-Secret' => $this->clientSecret
            ]
        ]);

        if (!$key = array_get(json_dec($response->getBody()->getContents(), true), 'key')) {
            throw new WrongResponseException;
        }

        return $key;
    }


    /**
     * Captcha input name
     *
     * @return string
     */
    public function getInputName()
    {
        return 'naver_recaptcha_response';
    }

    /**
     * Returns image source by key
     *
     * @param string $key captcha key
     * @return string
     */
    public function getImgSrc($key)
    {
        return $this->urlPrefix . 'ncaptcha.bin?key=' . $key;
    }

    /**
     * Create client for api request
     *
     * @return Client
     */
    protected function createClient()
    {
        return new Client([
            'base_uri'        => $this->urlPrefix,
            'timeout'         => $this->timeout,
            'allow_redirects' => false,
        ]);
    }
}
