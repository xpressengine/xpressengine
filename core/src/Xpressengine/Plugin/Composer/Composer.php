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

use Composer\Plugin\CommandEvent;
use Composer\Script\Event;
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
    protected static $metaFileName = 'composer.json';

    protected static $pluginsDir = 'plugins';

    protected static $packagistUrl = 'https://xpressengine.io';

    protected static $composerFile = 'storage/app/composer.plugins.json';

    protected static $installedFlagPath = 'storage/app/installed';

    public static $basePlugins = [
        'xpressengine-plugin/alice' => '0.9.1',
        'xpressengine-plugin/claim' => '0.9.1',
        'xpressengine-plugin/board' => '0.9.1',
        'xpressengine-plugin/ckeditor' => '0.9.1',
        'xpressengine-plugin/comment' => '0.9.1',
        'xpressengine-plugin/page' => '0.9.0',
        'xpressengine-plugin/news_client' => '0.9.0',
        "xpressengine-plugin/google_analytics" => "0.9.0",
        "xpressengine-plugin/orientator" => "0.9.0",
        "xpressengine-plugin/external_page" => "0.9.0",
        "xpressengine-plugin/social_login" => "0.9.1",
    ];

    /**
     * composer가 실행될 때 호출된다. composer.plugins.json 파일이 있는지 조사하고, 생성한다.
     *
     * @param CommandEvent $event composer가 제공하는 event
     *
     * @return void
     */
    public static function init(CommandEvent $event)
    {
        $path = static::$composerFile;
        $writer = self::getWriter($path);

        // composer.plugins.json 파일이 존재하지 않을 경우 초기화
        $writer->resolvePlugins()->write();

        // XE가 설치돼 있지 않을 경우, base plugin require에 추가
        if (!file_exists(static::$installedFlagPath)) {
            foreach (static::$basePlugins as $plugin => $version) {
                $writer->install($plugin, $version);
            }
            static::applyRequire($writer);
            $writer->setFixMode();
            $event->getOutput()->writeln("xpressengine-installer: running in update mode");
        } else {
            static::applyRequire($writer);
            if (static::isUpdateMode($event)) {
                $writer->setUpdateMode();
                $event->getOutput()->writeln("xpressengine-installer: running in update mode");
            } else {
                $writer->setFixMode();
                $event->getOutput()->writeln("xpressengine-installer: running in fix mode");
            }
        }
        $writer->write();

        $event->getOutput()->writeln("xpressengine-installer: Plugin composer file[$path] is written");
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
        $path = static::$composerFile;

        // XE가 설치돼 있지 않을 경우, resolve plugins
        $writer = self::getWriter($path);
        $writer->resolvePlugins()->setFixMode()->write();
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
        $reader = new MetaFileReader(static::$metaFileName);
        $scanner = new PluginScanner($reader, static::$pluginsDir);
        $writer = new ComposerFileWriter($path, $scanner, static::$packagistUrl);

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
        $installs = $writer->get('xpressengine-plugin.install', []);
        foreach ($installs as $name => $version) {
            $writer->addRequire($name, $version);
        }
        $updates = $writer->get('xpressengine-plugin.update', []);
        foreach ($updates as $name => $version) {
            $writer->addRequire($name, $version);
        }
        $uninstalls = $writer->get('xpressengine-plugin.uninstall', []);
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
            return ($packages && strpos($packages, 'xpressengine-plugin') === 0);
        } else {
            return false;
        }
    }
}
