<?php
/**
 * Presenter
 *
 * PHP version 7
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */
namespace Xpressengine\Presenter;

use Illuminate\Routing\Redirector as BaseRedirector;

/**
 * Redirector
 *
 * @category  Presenter
 * @package   Xpressengine\Presenter
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
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
