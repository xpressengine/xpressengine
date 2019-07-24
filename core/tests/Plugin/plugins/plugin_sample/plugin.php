<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2019 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Plugin\Sample;


use Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Xpressengine\Plugin\AbstractPlugin;

class PluginSample extends AbstractPlugin
{

    /**
     * @return boolean
     */
    public function install()
    {
        // TODO: Implement install() method.
    }

    /**
     * @return boolean
     */
    public function unInstall()
    {
        // TODO: Implement unInstall() method.
    }

    /**
     * @return boolean
     */
    public function checkInstall($installedVersion = null)
    {
        // TODO: Implement checkInstall() method.

        return true;
    }

    /**
     * @return boolean
     */
    public function checkUpdate($currentVersion = null)
    {
        return false;
    }

    public function boot()
    {
        // 라우트 등록
        intercept('Plugin@addPluginRoutes', 'route_for_pluginsample',
            function ($target, &$args) {
                $routes = $args[0];
                $this->registerAssignedRoute($routes);
                $target($args);
            }
        );

        $args::get('/manage', function () {
           return 'hihihi';
        });
    }

    public function registerAssignedRoute(&$routes)
    {


        $routes->{$this->pluginId} = function () {

            // for static action
            require_once('board_manager.php');

            Route::get('/manage', function () {
                $boardManager = BoardManager::getInstance();
                return $boardManager->getIndex();
            });
            Route::get('/manage/list', function () {
                $boardManager = BoardManager::getInstance();
                return $boardManager->getList();
            });

            // for dynamic action(using alias)
            require_once('board.php');

            Route::get('{bid}/list', function ($bid) {
                $board = Board::getInstance();
                return $board->getList($bid);
            });

            Route::get('{bid}/setting', function ($bid) {
                $board = Board::getInstance();
                return $board->getSetting($bid);
            });

            Route::get('{bid}/{act?}', function ($bid, $act = null) {

                $act    = $act ?: \Input::get('act', 'list');
                $board  = Board::getInstance();
                $method = 'get'.studly_case($act);
                if (method_exists($board, $method)) {
                    return $board->$method($bid);
                }

                throw new NotFoundHttpException();
            });
        };
    }
}
