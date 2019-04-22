<?php
/**
 * Application.php
 *
 * PHP version 7
 *
 * @category    Foundation
 * @package     Xpressengine\Foundation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Foundation;

use Illuminate\Foundation\Application as BaseApplication;

/**
 * Class Application
 *
 * @category    Foundation
 * @package     Xpressengine\Foundation
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class Application extends BaseApplication
{
    /**
     * The custom public path defined by the developer.
     *
     * @var string
     */
    protected $publicPath;

    /**
     * Get the path to the public / web directory.
     *
     * @return string
     */
    public function publicPath()
    {
        return $this->publicPath ?: $this->basePath;
    }

    /**
     * Set the public directory.
     *
     * @param string $path path for the public
     * @return $this
     */
    public function usePublicPath($path)
    {
        $this->publicPath = $path;

        $this->instance('path.public', $path);

        return $this;
    }

    /**
     * Get the path to the plugins directory.
     *
     * @return string
     */
    public function pluginsPath()
    {
        return $this->basePath.DIRECTORY_SEPARATOR.'plugins';
    }

    /**
     * Get the path to the proxies directory.
     *
     * @return string
     */
    public function proxiesPath()
    {
        return $this->storagePath().DIRECTORY_SEPARATOR.'app'.DIRECTORY_SEPARATOR.'interception';
    }

    /**
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function bindPathsInContainer()
    {
        parent::bindPathsInContainer();

        $this->instance('path.plugins', $this->pluginsPath());
        $this->instance('path.proxies', $this->proxiesPath());
    }

    /**
     * Get the path to the cached plugins.php file.
     *
     * @return string
     */
    public function getCachedPluginsPath()
    {
        return $this->bootstrapPath().'/cache/plugins.php';
    }

    /**
     * Register the core class aliases in the container.
     *
     * @return void
     */
    public function registerCoreContainerAliases()
    {
        $map = [
            'app' => [
                 static::class,
                 \Illuminate\Foundation\Application::class,
                 \Illuminate\Contracts\Container\Container::class,
                 \Illuminate\Contracts\Foundation\Application::class,
                 \Psr\Container\ContainerInterface::class
            ],
            'auth' => [\Illuminate\Auth\AuthManager::class, \Illuminate\Contracts\Auth\Factory::class],
            'auth.driver' => [\Illuminate\Contracts\Auth\Guard::class],
            'blade.compiler' => [\Illuminate\View\Compilers\BladeCompiler::class],
            'cache' => [\Illuminate\Cache\CacheManager::class, \Illuminate\Contracts\Cache\Factory::class],
            'cache.store' => [\Illuminate\Cache\Repository::class, \Illuminate\Contracts\Cache\Repository::class],
            'config' => [\Illuminate\Config\Repository::class, \Illuminate\Contracts\Config\Repository::class],
            'cookie' => [
                \Illuminate\Cookie\CookieJar::class,
                \Illuminate\Contracts\Cookie\Factory::class,
                \Illuminate\Contracts\Cookie\QueueingFactory::class
            ],
            'encrypter' => [\Illuminate\Encryption\Encrypter::class, \Illuminate\Contracts\Encryption\Encrypter::class],
            'db' => [\Illuminate\Database\DatabaseManager::class],
            'db.connection' => [
                \Illuminate\Database\Connection::class,
                \Illuminate\Database\ConnectionInterface::class
            ],
            'events' => [\Illuminate\Events\Dispatcher::class, \Illuminate\Contracts\Events\Dispatcher::class],
            'files' => [\Illuminate\Filesystem\Filesystem::class],
            'filesystem' => [
                \Illuminate\Filesystem\FilesystemManager::class,
                \Illuminate\Contracts\Filesystem\Factory::class
            ],
            'filesystem.disk' => [\Illuminate\Contracts\Filesystem\Filesystem::class],
            'filesystem.cloud' => [\Illuminate\Contracts\Filesystem\Cloud::class],
            'hash' => [\Illuminate\Contracts\Hashing\Hasher::class],
            'translator' => [
                \Illuminate\Translation\Translator::class,
                \Illuminate\Contracts\Translation\Translator::class
            ],
            'log' => [
                \Illuminate\Log\Writer::class,
                \Illuminate\Contracts\Logging\Log::class,
                \Psr\Log\LoggerInterface::class],
            'mailer' => [
                \Illuminate\Mail\Mailer::class,
                \Illuminate\Contracts\Mail\Mailer::class,
                \Illuminate\Contracts\Mail\MailQueue::class
            ],
            'auth.password' => [
                \Illuminate\Auth\Passwords\PasswordBrokerManager::class,
                \Illuminate\Contracts\Auth\PasswordBrokerFactory::class
            ],
            'auth.password.broker' => [
                \Illuminate\Auth\Passwords\PasswordBroker::class,
                \Illuminate\Contracts\Auth\PasswordBroker::class
            ],
            'queue' => [
                \Illuminate\Queue\QueueManager::class,
                \Illuminate\Contracts\Queue\Factory::class,
                \Illuminate\Contracts\Queue\Monitor::class
            ],
            'queue.connection' => [\Illuminate\Contracts\Queue\Queue::class],
            'queue.failer' => [\Illuminate\Queue\Failed\FailedJobProviderInterface::class],
            'redirect' => [\Illuminate\Routing\Redirector::class],
            'redis' => [\Illuminate\Redis\RedisManager::class, \Illuminate\Contracts\Redis\Factory::class],
            'request' => [
                \Xpressengine\Http\Request::class,
                \Illuminate\Http\Request::class,
                \Symfony\Component\HttpFoundation\Request::class
            ],
            'router' => [
                \Illuminate\Routing\Router::class,
                \Illuminate\Contracts\Routing\Registrar::class,
                \Illuminate\Contracts\Routing\BindingRegistrar::class
            ],
            'session' => [\Illuminate\Session\SessionManager::class],
            'session.store' => [\Illuminate\Session\Store::class, \Illuminate\Contracts\Session\Session::class],
            'url' => [\Illuminate\Routing\UrlGenerator::class, \Illuminate\Contracts\Routing\UrlGenerator::class],
            'validator' => [\Illuminate\Validation\Factory::class, \Illuminate\Contracts\Validation\Factory::class],
            'view' => [\Illuminate\View\Factory::class, \Illuminate\Contracts\View\Factory::class],
        ];
        foreach ($map as $key => $aliases) {
            foreach ($aliases as $alias) {
                $this->alias($key, $alias);
            }
        }
    }
}
