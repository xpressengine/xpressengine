<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category
 * @package     Xpressengine\
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
namespace Xpressengine\Plugin\Composer;

use Composer\Script\Event;
use Xpressengine\Plugin\MetaFileReader;
use Xpressengine\Plugin\PluginScanner;

/**
 * @category
 * @package     Xpressengine\Plugin
 * @author      XE Team (developers) <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        http://www.xpressengine.com
 */
class Composer
{
    protected static $installedFlagPath = 'storage/app/installed';

    protected static $metaFileName = 'composer.json';

    protected static $pluginsDir = 'plugins';

    protected static $packagistUrl = 'http://xpressengine.io';

    public static $basePlugins = [
        'xpressengine-plugin/alice' => '0.9.0',
        'xpressengine-plugin/claim' => '0.9.0',
        'xpressengine-plugin/board' => '0.9.0',
        'xpressengine-plugin/ckeditor' => '0.9.0',
        'xpressengine-plugin/comment' => '0.9.0',
        'xpressengine-plugin/page' => '0.9.0',
        'xpressengine-plugin/news_client' => '0.9.0',
    ];

    public static function requireBasePlugins(Event $event)
    {
        $extra = $event->getComposer()->getPackage()->getExtra();
        $path = static::getPath($extra);

        // XE가 이미 설치돼 있을 경우 아무 것도 하지 않는다.
        if(file_exists($path) || file_exists(static::$installedFlagPath)) {
            $event->getIO()->write("xpressengine-installer: : Xpressengine was installed or file[$path] already exists!");
            return;
        }

        // XE가 설치돼 있지 않을 경우, composer.plugins.json 파일을 생성한다.
        $writer = self::getWriter($path);
        $writer->setFixMode();

        foreach (static::$basePlugins as $plugin => $version) {
            $writer->addRequire($plugin, $version);
        }

        $writer->write();
        $event->getIO()->write('xpressengine-installer: : Plugin composer file is generated');
    }

    public static function resolvePlugins(Event $event)
    {
        $extra = $event->getComposer()->getPackage()->getExtra();
        $path = static::getPath($extra);

        // XE가 이미 설치돼 있을 경우 아무 것도 하지 않는다.
        if(file_exists(static::$installedFlagPath)) {
            return;
        }

        // XE가 설치돼 있지 않을 경우, resolve plugins
        $writer = self::getWriter($path);
        $writer->resolvePlugins()->setFixMode()->write();
    }

    /**
     * getWriter
     *
     * @param string $path
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
     * init
     *
     * @param $extra
     *
     * @return mixed
     * @throws \Exception
     */
    protected static function getPath($extra)
    {
        if (!isset($extra['xpressengine-plugin']['path'])) {
            throw new \Exception('xpressengine-installer: extra > xpressengine-plugin > path is required.');
        }
        $path = $extra['xpressengine-plugin']['path'];
        return $path;
    }
}
