<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Log
 * @package     Xpressengine\Log
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Log\Loggers;

use Illuminate\Contracts\Foundation\Application;
use Xpressengine\Http\Request;
use Xpressengine\Log\AbstractLogger;
use Xpressengine\Log\Models\Log;
use Xpressengine\User\Rating;

/**
 * @category    Log
 * @package     Xpressengine\Log
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class UserLogger extends AbstractLogger
{
    const ID = 'user';

    const TITLE = '회원';

    protected $app;

    /**
     * Logger Init 세팅
     *
     * @param Application $app app
     *
     * @return void
     */
    public function initLogger(Application $app)
    {
        $this->app = $app;

        $app['events']->listen('Illuminate\Foundation\Http\Events\RequestHandled', function ($result) {
            if ($result->request->route() == null) {
                return;
            }

            $this->writeLog($result->request, self::getSummary($result->request));
        });

        $this->registerIntercept();
    }

    /**
     * route name 확인해서 로그 종류 검색
     *
     * @param Request $request request
     *
     * @return string|null
     */
    protected function getSummary(Request $request)
    {
        $list = [
            'settings.user.index' => '회원목록 열람',
            'settings.user.edit' => '회원상세정보 열람',
            'settings.user.store' => '회원 추가',
            'settings.user.mail.add' => '회원 이메일 추가',
            'settings.user.mail.delete' => '회원 이메일 삭제',
            'settings.user.mail.confirm' => '회원 이메일 승인',
            'settings.user.update' => '회원정보 수정',
            'settings.user.destroy' => '회원정보 삭제',
        ];

        return $list[$request->route()->getName()] ?? null;
    }

    /**
     * Get target Id
     *
     * @param Request $request request
     *
     * @return string
     */
    protected function getTargetId(Request $request)
    {
        $targetId = '';
        switch ($request->route()->getName()) {
            case 'settings.user.edit':
            case 'settings.user.update':
                $targetId = $request->route()->parameter('id');
                break;
                
            case 'settings.user.destroy':
                $targetId = $request->get('userId', []);
                if (is_array($targetId) === true) {
                    $targetId = implode(',', $targetId);
                }
                break;
                
            case 'settings.user.mail.add':
            case 'settings.user.mail.delete':
                $targetId = $request->get('userId');
                break;
        }

        return $targetId;
    }
    
    /**
     * 회원 권한 변경 로그 작성 인터셉트 등록
     *
     * @return void
     */
    protected function registerIntercept()
    {
        intercept(
            'Xpressengine\User\UserHandler@update',
            'UserLogger::user.update',
            function ($target, $user, $userData) {
                $updateUser['beforeRating'] = $user['rating'];

                $afterUpdateUser = $target($user, $userData);

                $updateUser['afterRating'] = $user['rating'];
                $updateUser['userDisplayName'] = $user['display_name'];

                if ($updateUser['beforeRating'] != $updateUser['afterRating']) {
                    $request = request();

                    $ratingNames = [
                        Rating::USER => xe_trans('xe::userRatingNormal'),
                        Rating::MANAGER => xe_trans('xe::userRatingManager'),
                        Rating::SUPER => xe_trans('xe::userRatingAdministrator'),
                    ];

                    $summary = '회원 권한 수정 (' . $updateUser['userDisplayName'] . ' : '
                        . $ratingNames[$updateUser['beforeRating']] . '=>'
                        . $ratingNames[$updateUser['afterRating']] . ')';

                    $this->writeLog($request, $summary);
                }

                return $afterUpdateUser;
            }
        );
    }

    /**
     * 로그 작성 대상 route가 맞는지 확인
     * 로그 작성 전 관리자 확인
     *
     * @param Request $request request
     * @param string  $summary log 요약
     *
     * @return void
     */
    protected function writeLog(Request $request, $summary)
    {
        if ($summary === null) {
            return;
        }

        if (!$this->isAdmin($request)) {
            return;
        }

        $this->storeLog($request, $summary);
    }

    /**
     * 로그 작성
     *
     * @param Request $request request
     * @param string  $summary log 요약
     *
     * @return void
     */
    protected function storeLog(Request $request, $summary)
    {
        $data = $this->loadRequest($request);
        
        array_set($data['data'], 'route', $request->route()->getName());
        array_forget($data['parameters'], 'password');
        
        $data['summary'] = $summary;

        $this->log($data);
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
