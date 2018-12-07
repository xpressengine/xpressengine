<?php
/**
 * Controller.php
 *
 * PHP version 7
 *
 * @category    Controllers
 * @package     App\Http\Controllers
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
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
 * @license     https://opensource.org/licenses/MIT MIT
 * @link        https://laravel.com
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
