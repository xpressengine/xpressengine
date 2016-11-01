<?php
/**
 * Presenter
 *
 * PHP version 5
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */
namespace Xpressengine\Presenter;

use Illuminate\Routing\Redirector as BaseRedirector;

/**
 * Redirector
 *
 * Routing Rediretor 확장해서 XE의 RedirectResponse를 사용하도록 처리
 *
 * Presenter에서 API로 기능을 제공할 때 redirect 요청에 대한 처리에 문제가 있음
 *
 * Laravel 에서 제공하는 Redirect 파사드, redirect() 헬퍼 함수를 대신해서
 * 사용할 수 있도록 기능 제공
 *
 * XeRedirect 파사드 xeRedirect() 헬퍼 함수 제공
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */
class Redirector extends BaseRedirector
{
    /**
     * Create a new redirect response.
     * @param string $path    path
     * @param int    $status  status
     * @param array  $headers header
     * @return RedirectResponse
     */
    public function createRedirect($path, $status, $headers)
    {
        $redirect = new RedirectResponse($path, $status, $headers);

        if (isset($this->session)) {
            $redirect->setSession($this->session);
        }

        $redirect->setRequest($this->generator->getRequest());

        return $redirect;
    }
}
