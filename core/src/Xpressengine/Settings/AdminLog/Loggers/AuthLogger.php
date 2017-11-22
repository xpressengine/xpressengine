<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    AdminLog
 * @package     Xpressengine\Settings\AdminLog
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Settings\AdminLog\Loggers;

use Xpressengine\Http\Request;
use Xpressengine\Settings\AdminLog\AbstractLogger;
use Xpressengine\Settings\AdminLog\Models\Log;

/**
 * @category    AdminLog
 * @package     Xpressengine\Settings\AdminLog
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class AuthLogger extends AbstractLogger
{
    const ID = 'auth';

    const TITLE = '로그인';

    protected $matched;
    /**
     * run logging request
     *
     * @param Request $request incoming request
     *
     * @return void
     */
    public function run(Request $request)
    {
        $run = $this->matched;
        if ($run !== null) {
            $data = $this->loadRequest($request);
            array_set($data['data'], 'route', $request->route()->getName());
            $run($data);
            $this->log($data);
        }
    }

    /**
     * matches
     *
     * @param Request $request incoming request
     *
     * @return boolean
     */
    public function matches(Request $request)
    {
        if (!$route = $request->route()) {
            return false;
        }
        if (!$name = $route->getName()) {
            return false;
        }

        $method = strtoupper($request->method());
        $this->matched = $matched = array_get(array_get($this->getMatchList(), $method, []), $name);

        return $matched ? true : false;
    }

    /**
     * match target list
     *
     * @return array
     */
    protected function getMatchList()
    {
        return [
            'GET' => [
                'logout' => function (array &$data) {
                    $data['summary'] = '로그아웃';
                },
            ],
            'POST' => [
                'login' => function (array &$data) {
                    $data['summary'] = '로그인';
                    array_forget($data['parameters'], 'password');
                },
            ]
        ];
    }

    /**
     * render log entity to html
     *
     * @param Log $log log entity
     *
     * @return string|null
     */
    public function renderDetail(Log $log)
    {
        return null;
    }
}
