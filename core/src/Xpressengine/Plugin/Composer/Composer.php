<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Plugin\Composer;

use Composer\Installer\InstallerEvent;
use Composer\Plugin\CommandEvent;
use Composer\Script\Event;
use Illuminate\Foundation\Application;
use Xpressengine\Installer\XpressengineInstaller;
use Xpressengine\Plugin\MetaFileReader;
use Xpressengine\Plugin\PluginScanner;

/**
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Composer
{
    protected static $composerFile = 'composer.json';

    protected static $pluginsDir = 'plugins';

    protected static $packagistUrl = null;

    protected static $packagistToken = null;

    protected static $pluginComposerFile = 'storage/app/composer.plugins.json';

    protected static $installedFlagPath = 'storage/app/installed';

    public static $basePlugins = [
        'xpressengine-plugin/alice' => '0.9.7',
        'xpressengine-plugin/board' => '0.9.13',
        'xpressengine-plugin/ckeditor' => '0.9.9',
        'xpressengine-plugin/claim' => '0.9.3',
        'xpressengine-plugin/comment' => '0.9.7',
        'xpressengine-plugin/external_page' => '0.9.4',
        'xpressengine-plugin/google_analytics' => '0.9.2',
        'xpressengine-plugin/news_client' => '0.9.3',
        'xpressengine-plugin/orientator' => '0.9.1',
        'xpressengine-plugin/page' => '0.9.2',
        'xpressengine-plugin/social_login' => '0.9.7',
        'xpressengine-plugin/emoticon' => '0.9.0',
        'xpressengine-plugin/widget_page' => '0.9.0'
    ];

    /**
     * @param string $packagistUrl
     */
    public static function setPackagistUrl($packagistUrl)
    {
        self::$packagistUrl = $packagistUrl;
    }

    /**
     * @param null $authToken
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

        $path = static::$pluginComposerFile;
        $writer = self::getWriter($path);
        $writer->reset();

        // XE가 설치돼 있지 않을 경우, base plugin require에 추가
        if (!file_exists(static::$installedFlagPath)) {
            if (!defined('__XE_PLUGIN_MODE__')) {
                define('__XE_PLUGIN_MODE__', true);
            }
            foreach (static::$basePlugins as $plugin => $version) {
                if ($writer->get('replace.'.$plugin) === null) {
                    $writer->install($plugin, $version, date("Y-m-d H:i:s"));
                } else {
                    $event->getOutput()->writeln(
                        "xpressengine-installer: skip installation of existing plugin: $plugin"
                    );
                }
            }
            static::applyRequire($writer);
            $event->getOutput()->writeln("xpressengine-installer: running in initialize mode");
        } else {

            // 플러그인 명령을 실행한 경우
            if (defined('__XE_PLUGIN_MODE__')) {
                static::applyRequire($writer);
                $writer->setUpdateMode();
                $event->getOutput()->writeln("xpressengine-installer: running in update mode");
            // composer를 직접 실행한 경우
            } else {
                $writer->setFixMode();
                $event->getOutput()->writeln("xpressengine-installer: running in fix mode");
            }
        }
        $writer->write();

        $event->getOutput()->writeln("xpressengine-installer: Plugin composer file[$path] is written");
    }

    /**
     * preUpdateOrInstall
     *
     * @param Event $event
     *
     * @return void
     */
    public static function preUpdateOrInstall(Event $event)
    {
    }

    public static function postDependenciesSolving(InstallerEvent $event)
    {
        if(static::$packagistUrl !== null && static::$packagistToken !== null) {
            $io = $event->getIO();
            $host = parse_url(static::$packagistUrl, PHP_URL_HOST);
            $token = static::$packagistToken;
            $io->setAuthentication($host, $token);
        }
    }

    /**
     * composer 실행중 post-install-cmd, post-update-cmd 이벤트가 발생할 경우 실행된다.
     * composer.plugins.json 파일을 현재 XE 상태에 맞춰 갱신한다.
     *
     * @param Event $event composer가 제공하는 event
     *
     * @return void
     */
    public static function postUpdate(Event $event)
    {
        $path = static::$pluginComposerFile;

        $writer = self::getWriter($path);

        if (!file_exists(static::$installedFlagPath)) {
            $writer->cleanOperation();
        } else {
            $writer->set('xpressengine-plugin.operation.changed', XpressengineInstaller::$changed);
        }
        $writer->reset()->write();

        require_once $event->getComposer()->getConfig()->get('vendor-dir').'/autoload.php';
        static::clearCompiled();
    }

    /**
     * ComposerFileWriter 인스턴스를 생성한다.
     *
     * @param string $path plugin용 composer 파일 경로
     *
     * @return ComposerFileWriter
     * @throws \Exception
     */
    protected static function getWriter($path)
    {
        $reader = new MetaFileReader(static::$composerFile);
        $scanner = new PluginScanner($reader, static::$pluginsDir);
        $writer = new ComposerFileWriter($path, $scanner);

        return $writer;
    }

    /**
     * plugin composer 파일에 등록된 플러그인 제어정보를 require에 적용한다.
     *
     * @param ComposerFileWriter $writer composer file writer
     *
     * @return void
     */
    private static function applyRequire(ComposerFileWriter $writer)
    {
        $installs = $writer->get('xpressengine-plugin.operation.install', []);
        foreach ($installs as $name => $version) {
            $writer->addRequire($name, $version);
        }
        $updates = $writer->get('xpressengine-plugin.operation.update', []);
        foreach ($updates as $name => $version) {
            $writer->addRequire($name, $version);
        }
        $uninstalls = $writer->get('xpressengine-plugin.operation.uninstall', []);
        foreach ($uninstalls as $name) {
            $writer->removeRequire($name);
        }
    }

    /**
     * 플러그인 커맨드를 통해 composer가 실행된 상태인지 조사한다.
     *
     * @param CommandEvent $event composer가 제공하는 event
     *
     * @return bool
     */
    private static function isUpdateMode(CommandEvent $event)
    {
        if ($event->getInput()->hasArgument('packages')) {
            $packages = $event->getInput()->getArgument('packages');
            $packages = array_shift($packages);
            if ($packages && strpos($packages, 'xpressengine-plugin') === 0) {
                if (!defined('__XE_PLUGIN_MODE__')) {
                    define('__XE_PLUGIN_MODE__', true);
                }
                return true;
            }
        }
        return false;
    }

    /**
     * Clear the cached Laravel bootstrapping files.
     *
     * @return void
     */
    protected static function clearCompiled()
    {

        if(!$laravel = Application::getInstance()) {
            $laravel = new Application(getcwd());
        }

        if (file_exists($compiledPath = $laravel->getCachedCompilePath())) {
            @unlink($compiledPath);
        }

        if (file_exists($servicesPath = $laravel->getCachedServicesPath())) {
            @unlink($servicesPath);
        }
    }

}
