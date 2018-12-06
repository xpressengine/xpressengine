<?php
/**
 * Controller.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Xpressengine\Support\ValidatesRequestsTrait;
use Xpressengine\Permission\Instance;

/**
 * Class Controller
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequestsTrait;

    /**
     * Authorize a given action for the current user.
     *
     * @param string $ability    ability name
     * @param string $instanceId instance id
     * @return \Illuminate\Auth\Access\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authorizeInstance($ability, $instanceId)
    {
        return $this->authorize($ability, new Instance($instanceId));
    }
}
