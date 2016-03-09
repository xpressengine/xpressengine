<?php
/**
 * Service provider
 *
 * PHP version 5
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Comment\CommentEntity;
use Xpressengine\Comment\CommentHandler;
use Xpressengine\Database\VirtualConnection;
use Xpressengine\Document\ConfigHandler;
use Xpressengine\Document\DocumentHandler;
use Xpressengine\Document\InstanceManager;
use Xpressengine\Document\Models\Document;
use Xpressengine\Document\Models\Revision;
use Xpressengine\Document\RevisionHandler;
use Xpressengine\Keygen\Keygen;
use Xpressengine\User\UserInterface;

/**
 * laravel service provider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class DocumentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Document::creating(function(Document $model) {
            $model->setReply();
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        // set reply code length config to Document model
        Document::setReplyCharLen($app['config']['xe.documentReplyCodeLen']);

        $app->singleton('xe.document.config', function ($app) {
            return new ConfigHandler($app['xe.config']);
        });
        $app->singleton('xe.document.revision', function ($app) {
            $revisionHandlerClass = $app['xe.interception']->proxy(RevisionHandler::class, 'DocumentRevisionHandler');
            return new $revisionHandlerClass(
                $app['xe.document.config'],
                $app['xe.dynamicField']
            );
        });
        $app->singleton('xe.document.instance', function ($app) {
            $instanceManagerClass = $app['xe.interception']->proxy(InstanceManager::class, 'DocumentInstanceManager');
            return new $instanceManagerClass(
                $app['xe.db']->connection('document'),
                $app['xe.document.config']
            );
        });
        $app->singleton('xe.document', function ($app) {
            $documentHandlerClass = $app['xe.interception']->proxy(DocumentHandler::class, 'Document');
            $document = new $documentHandlerClass(
                $app['xe.db']->connection('document'),
                $app['xe.document.config'],
                $app['xe.document.instance'],
                $app['request']
            );

            return $document;
        });

        $app->bind(
            DocumentHandler::class,
            'xe.document'
        );


        $this->registerCommentIntercept();
    }

    /**
     * register comment intercept
     *
     * @return void
     */
    protected function registerCommentIntercept()
    {
        $app = $this->app;
        // add comment interception
        intercept(
            'Comment@add',
            'DocumentCommentCountIncrease',
            function($method, CommentEntity $comment, UserInterface $user = null) use ($app) {
                /** @var VirtualConnection $conn */
                $conn = $app['xe.db']->connection('document');
                $conn->beginTransaction();

                // add comment
                $result = $method($comment, $user);

                /** @var DocumentHandler $documentHandler */
                $documentHandler = app('xe.document');
                $doc = $documentHandler->get($comment->targetId, $comment->instanceId);

                /** @var CommentHandler $commentHandler */
                $commentHandler = app('xe.comment');
                $doc->commentCount = $commentHandler->countAllByTarget($comment->instanceId, $comment->targetId);
                $documentHandler->put($doc);

                $conn->commit();

                return $result;
            }
        );

        intercept(
            'Comment@remove',
            'DocumentCommentCountDecrease',
            function($method, CommentEntity $comment) use ($app) {
                /** @var VirtualConnection $conn */
                $conn = $app['xe.db']->connection('document');
                $conn->beginTransaction();

                // remove comment
                $result = $method($comment);

                /** @var DocumentHandler $documentHandler */
                $documentHandler = app('xe.document');
                $doc = $documentHandler->get($comment->targetId, $comment->instanceId);

                /** @var CommentHandler $commentHandler */
                $commentHandler = app('xe.comment');
                $doc->commentCount = $commentHandler->countAllByTarget($comment->instanceId, $comment->targetId);
                $documentHandler->put($doc);

                $conn->commit();

                return $result;
            }
        );
    }
}
