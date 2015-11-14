<?php
/**
 * This file is service provider for laravel
 *
 * PHP version 5
 *
 * @category    Comment
 * @package     Xpressengine\Comment
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Comment\CommentEntity;
use Xpressengine\Comment\CommentHandler;
use Xpressengine\Comment\Repositories\CommentRepository;
use Xpressengine\Comment\Repositories\DivisionDecorator;
use Xpressengine\Member\Entities\MemberEntityInterface;

/**
 * laravel 에서의 사용을 위한 등록 처리
 *
 * @category    Comment
 * @package     Xpressengine\Comment
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class CommentServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $source = base_path('core/src/Xpressengine/Comment/config/comment.php');
        $this->mergeConfigFrom($source, 'comment');

        CommentEntity::setReplyCharlen($this->app['config']['comment.commentReplyCodeLen']);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('xe.comment', function ($app) {
            $repo = new CommentRepository(
                $app['xe.db']->connection('comment'),
                $app['xe.keygen']
            );

            // xe.db 에서 schema builder 반환하는지 확인
            $decorator = new DivisionDecorator(
                $repo,
                $app['db']->connection()->getSchemaBuilder(),
                $app['config']['comment.schema'],
                $app['xe.config']
            );


            $proxyClass = $app['xe.interception']->proxy(CommentHandler::class, 'Comment');
            $comment = new $proxyClass(
                $app['xe.member'],
                $app['xe.auth'],
                $decorator,
                $app['xe.config'],
                $app['session.store'],
                $app['xe.counter']
            );
            return $comment;
        }, true);

        $this->app->bind(CommentHandler::class, 'xe.comment');


        // manage menu 등록
        intercept(
            'Settings@getManageMenu',
            ['comment.managemenu' => ['before' => 'manage.sort']],
            function ($target) {
                $menu          = $target();
                $menu['contents']['submenu']['comment'] = [
                    'title' => '댓글',
                    'description' => 'blur blur~',
                    'link' => '/manage/comment'

                ];
                return $menu;
            }
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['xe.comment'];
    }
}
