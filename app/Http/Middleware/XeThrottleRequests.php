<?php
/**
 * XeThrottleRequests.php
 *
 * PHP version 7
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ThrottleRequests;

/**
 * Class XeThrottleRequests
 *
 * @category    Middleware
 * @package     App\Http\Middleware
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class XeThrottleRequests extends ThrottleRequests
{
    /**
     * Resolve request signature.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     * @throws \RuntimeException
     */
    protected function resolveRequestSignature($request)
    {
        $userResolver = $request->getUserResolver();

        // Set custom user resolver
        $request->setUserResolver(function () use ($userResolver) {
            $user = $userResolver();
            if ($user instanceof \Xpressengine\User\Models\User) {
                return $user;
            } else {
                return null;
            }
        });

        $key = parent::resolveRequestSignature($request);

        // Restore user resolver
        $request->setUserResolver($userResolver);

        return $key;
    }
}
