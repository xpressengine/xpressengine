<?php
/**
 * DocumentServiceProvider.php
 *
 * PHP version 7
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Xpressengine\Document\ConfigHandler;
use Xpressengine\Document\DocumentHandler;
use Xpressengine\Document\InstanceManager;
use Xpressengine\Document\Models\Document;
use XeDocument;

/**
 * Class DocumentServiceProvider
 *
 * @category    Providers
 * @package     App\Providers
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class DocumentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        // reply 설정을 위해 create event listener 등록
        Document::creating(function (Document $model) {
            $model->setReply();
        });

        Document::created(function (Document $model) {
            $instanceId = $model->getAttribute('instance_id');
            if ($instanceId === null || $instanceId == '') {
                return;
            }
            XeDocument::addDivision($model);
        });

        Document::updated(function (Document $model) {
            $instanceId = $model->getAttribute('instance_id');
            if ($instanceId === null || $instanceId == '') {
                return;
            }
            XeDocument::putDivision($model);
        });

        Document::deleting(function (Document $model) {
            $instanceId = $model->getAttribute('instance_id');
            if ($instanceId === null || $instanceId == '') {
                return;
            }
            XeDocument::removeDivision($model);
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
        $app->singleton('xe.document.instance', function ($app) {
            $instanceManagerClass = $app['xe.interception']->proxy(InstanceManager::class, 'DocumentInstanceManager');
            return new $instanceManagerClass(
                $app['xe.db']->connection(),
                $app['xe.document.config']
            );
        });
        $app->singleton(DocumentHandler::class, function ($app) {
            $documentHandlerClass = $app['xe.interception']->proxy(DocumentHandler::class, 'Document');
            $document = new $documentHandlerClass(
                $app['xe.db']->connection(),
                $app['xe.document.config'],
                $app['xe.document.instance'],
                $app['request']
            );

            return $document;
        });
        $app->alias(DocumentHandler::class, 'xe.document');
    }
}
