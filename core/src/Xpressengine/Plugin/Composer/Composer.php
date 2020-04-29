<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 7
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Plugin\Composer;

use Composer\Installer\InstallerEvent;
use Composer\Plugin\CommandEvent;
use Composer\Script\Event;
use FilesystemIterator;
use Xpressengine\Foundation\Application;
use Xpressengine\Plugin\MetaFileReader;
use Xpressengine\Plugin\PluginScanner;

/**
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Composer
{
    protected static $writer;

    protected static $composerFile = 'composer.json';

    protected static $pluginsDir = 'plugins';

    protected static $packagistUrl = 'store.xehub.io';

    protected static $packagistToken = null;

    protected static $pluginComposerFile = 'storage/app/composer.plugins.json';

    public static $basePlugins = [
        'xpressengine-plugin/board' => '*',
        'xpressengine-plugin/ckeditor' => '*',
        'xpressengine-plugin/claim' => '*',
        'xpressengine-plugin/comment' => '*',
        'xpressengine-plugin/demo_import' => '*',
        'xpressengine-plugin/news_client' => '*',
        'xpressengine-plugin/page' => '*',
        'xpressengine-plugin/together' => '*',
        'xpressengine-plugin/widget_page' => '*'
    ];

    /**
     * set target packagist url
     *
     * @param string $packagistUrl target packagist url
     *
     * @return void
     */
    public static function setPackagistUrl($packagistUrl)
    {
        self::$packagistUrl = $packagistUrl;
    }

    /**
     * set packagist auth token
     *
     * @param string $authToken auth token(site token)
     *
     * @return void
     */
    public static function setPackagistToken($authToken)
    {
        self::$packagistToken = $authToken;
    }

    /**
     * composer가 실행될 때 호출된다. composer.plugins.json 파일이 있는지 조사하고, 생성한다.
     *
     * @param CommandEvent $event composer가 제공하는 event
     *
     * @return void
     */
    public static function command(CommandEvent $event)
    {
        if (!in_array($event->getCommandName(), ['update', 'install'])) {
            return;
        }

        if (!file_exists(static::$pluginComposerFile)) {
            $writer = static::getWriter();
            foreach (static::$basePlugins as $name => $version) {
                $writer->addRequire($name, $version);
            }
            $writer->write();

            $event->getOutput()->writeln(
                'xpressengine : The bundle plugin is added to <info>composer require</info>'
            );
        }
    }

    /**
     * preUpdateOrInstall
     *
     * @param Event $event event object
     *
     * @return void
     */
    public static function preUpdateOrInstall(Event $event)
    {
    }

    /**
     * postDependenciesSolving
     *
     * @param InstallerEvent $event event object
     *
     * @return void
     */
    public static function postDependenciesSolving(InstallerEvent $event)
    {
        if (static::$packagistUrl !== null && static::$packagistToken !== null) {
            $event->getIO()->setAuthentication(static::$packagistUrl, static::$packagistToken);
        }
    }

    /**
     * Handle the post-install Composer event.
     *
     * @param Event $event composer event object
     * @return void
     */
    public static function postInstall(Event $event)
    {
        static::postUpdateOrInstall($event);
    }

    /**
     * Handle the post-update Composer event.
     *
     * @param Event $event composer event object
     * @return void
     */
    public static function postUpdate(Event $event)
    {
        static::postUpdateOrInstall($event);
    }

    /**
     * Handle the post-update or post-install Composer event.
     *
     * @param Event $event composer event object
     * @return void
     */
    public static function postUpdateOrInstall(Event $event)
    {
        static::getWriter()->reset()->write(true);
    }

    /**
     * composer 실행중 post-install-cmd, post-update-cmd 이벤트가 발생할 경우 실행된다.
     * composer.plugins.json 파일을 현재 XE 상태에 맞춰 갱신한다.
     *
     * @return void
     *
     * @deprecated since 3.0.1
     */
    protected static function wrapUp()
    {
    }

    /**
     * Handle the post-autoload-dump Composer event.
     *
     * @param Event $event composer event object
     * @return void
     */
    public static function postAutoloadDump(Event $event)
    {
        require_once $event->getComposer()->getConfig()->get('vendor-dir').'/autoload.php';

        static::clearCompiled();
    }

    /**
     * Clear the cached bootstrapping files.
     *
     * @return void
     */
    protected static function clearCompiled()
    {
        $application = defined('__RUN_IN_ARTISAN__') ? Application::getInstance() : new Application(getcwd());

        if (file_exists($packagesPath = $application->getCachedPackagesPath())) {
            @unlink($packagesPath);
        }

        if (file_exists($servicesPath = $application->getCachedServicesPath())) {
            @unlink($servicesPath);
        }

        if (file_exists($pluginsPath = $application->getCachedPluginsPath())) {
            @unlink($pluginsPath);
        }

        if (is_dir($proxiesPath = $application->proxiesPath())) {
            $items = new FilesystemIterator($proxiesPath, FilesystemIterator::SKIP_DOTS);
            foreach ($items as $item) {
                if ($item->isFile()) {
                    @unlink($item->getPathname());
                }
            }
        }
    }

    /**
     * ComposerFileWriter 인스턴스를 생성한다.
     *
     * @return ComposerFileWriter
     */
    protected static function getWriter()
    {
        if (!static::$writer) {
            $reader = new MetaFileReader(static::$composerFile);
            $scanner = new PluginScanner($reader, static::$pluginsDir, '');
            static::$writer = new ComposerFileWriter(static::$pluginComposerFile, $scanner);
        }

        return static::$writer;
    }

    /**
     * delete Directory
     *
     * @param string $directory directory
     * @param bool   $preserve  preserve
     *
     * @return bool
     *
     * @deprecated since 3.0.1
     */
    protected static function deleteDirectory($directory, $preserve = false)
    {
        return true;
    }
}
