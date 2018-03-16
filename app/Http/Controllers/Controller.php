<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Xpressengine\Support\ValidatesRequestsTrait;
use Xpressengine\Permission\Instance;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequestsTrait;

    public function authorizeInstance($ability, $instanceId)
    {
        return $this->authorize($ability, new Instance($instanceId));
    }
}
