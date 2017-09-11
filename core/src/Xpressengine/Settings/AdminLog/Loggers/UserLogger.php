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
class UserLogger extends AbstractLogger
{

    public static $id = 'user';

    public static $title = '회원';

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
            $run($request);
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
        /*
         * logging target list
         * 회원목록열람 GET: as(settings.user.index)
         * 회원상세열람 GET: as(settings.user.edit)
         * 회원수정 PUT: as(settings.user.update)
         * 회원추가 POST: as(settings.user.create)
         * 회원 이메일 추가, 삭제 POST: as(settings.user.mail.add)
         * 회원 이메일 추가, 삭제 POST: as(settings.user.mail.delete)
         * 회원 이메일 추가, 삭제 POST: as(settings.user.mail.confirm)
         * 회원삭제: DELETE: as(settings.user.destroy)
         * 로그인:
         * */
        $list = [
            'GET' => [
                'settings.user.index' => function (Request $request) {
                    $data = $this->loadRequest($request);
                    $data['summary'] = '회원목록 열람';
                    array_set($data['data'], 'route', $request->route()->getName());
                    $this->log($data);
                },
                'settings.user.edit' => function (Request $request) {
                    $data = $this->loadRequest($request);
                    $data['summary'] = '회원상세정보 열람';
                    array_set($data['data'], 'user_id', $request->route()->parameter('id'));
                    array_set($data['data'], 'route', $request->route()->getName());
                    $this->log($data);
                },
            ],
            'POST' => [
                'settings.user.create' => function (Request $request) {
                    $data = $this->loadRequest($request);
                    $data['summary'] = '회원 추가';
                    array_forget($data['parameters'], 'password');
                    array_set($data['data'], 'route', $request->route()->getName());
                    $this->log($data);
                },
                'settings.user.mail.add' => function (Request $request) {
                    $data = $this->loadRequest($request);
                    $data['summary'] = '회원 이메일 추가';
                    array_set($data['data'], 'user_id', $request->route()->parameter('id'));
                    array_set($data['data'], 'route', $request->route()->getName());
                    $this->log($data);
                },
                'settings.user.mail.delete' => function (Request $request) {
                    $data = $this->loadRequest($request);
                    $data['summary'] = '회원 이메일 삭제';
                    array_set($data['data'], 'user_id', $request->route()->parameter('id'));
                    array_set($data['data'], 'route', $request->route()->getName());
                    $this->log($data);
                },
                'settings.user.mail.confirm' => function (Request $request) {
                    $data = $this->loadRequest($request);
                    $data['summary'] = '회원 이메일 승인';
                    array_set($data['data'], 'user_id', $request->route()->parameter('id'));
                    array_set($data['data'], 'route', $request->route()->getName());
                    $this->log($data);
                },
            ],
            'PUT' => [
                'settings.user.update' => function (Request $request) {
                    $data = $this->loadRequest($request);
                    $data['summary'] = '회원정보 수정';
                    array_set($data['data'], 'user_id', $request->route()->parameter('id'));
                    array_forget($data['parameters'], 'password');
                    array_set($data['data'], 'route', $request->route()->getName());
                    $this->log($data);
                },
            ],
            'DELETE' => [
                'settings.user.destroy' => function (Request $request) {
                    $data = $this->loadRequest($request);
                    $data['summary'] = '회원정보 삭제';
                    array_set($data['data'], 'user_id', $request->route()->parameter('id'));
                    array_set($data['data'], 'route', $request->route()->getName());
                    $this->log($data);
                },
            ]
        ];

        $method = strtoupper($request->method());
        $route = $request->route();

        $matched = false;
        if ($route !== null) {
            $name = $request->route()->getName();
            if ($name !== null) {
                $this->matched = $matched = array_get(array_get($list, $method, []), $name);
            }
        }
        return $matched ? true : false;
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
