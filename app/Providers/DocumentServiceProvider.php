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
use Xpressengine\Document\Repositories\DocumentRepository;
use Xpressengine\Document\Repositories\RevisionRepository;
use Xpressengine\Document\Repositories\SlugRepository;
use Xpressengine\Document\Repositories\ReplyHelper;
use Xpressengine\Document\RepositoryHandler;
use Xpressengine\Keygen\Keygen;
use Xpressengine\Member\Entities\MemberEntityInterface;

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
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $app = $this->app;

        $app->singleton('xe.document', function ($app) {
            $configHandler = new ConfigHandler($app['xe.config']);

            $connection = $app['xe.db']->connection('document');

            // set revision
            $revisionRepository = new RevisionRepository($connection, $app['xe.dynamicField.revision'], new Keygen);

            // set repository
            $documentRepository = new DocumentRepository($connection);

            // set repository handler
            $repositoryHandler = new RepositoryHandler(
                $connection,
                $documentRepository,
                $revisionRepository,
                new ReplyHelper($app['config']['xe.documentReplyCodeLen'])
            );

            $instanceManagerClass = $app['xe.interception']->proxy(InstanceManager::class, 'DocumentInstanceManager');

            $instanceManager = new $instanceManagerClass(
                $repositoryHandler,
                $configHandler
            );

            $documentHandlerClass = $app['xe.interception']->proxy(DocumentHandler::class, 'Document');
            $document = new $documentHandlerClass(
                $connection,
                $repositoryHandler,
                $configHandler,
                $instanceManager,
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
            function($method, CommentEntity $comment, MemberEntityInterface $user = null) use ($app) {
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
