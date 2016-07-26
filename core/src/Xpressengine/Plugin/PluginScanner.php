<?php
/**
 *  This file is part of the Xpressengine package.
 *
 * PHP version 5
 *
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */

namespace Xpressengine\Plugin;

use Xpressengine\Plugin\Exceptions\InvaildPluginFileFormatException;
use Xpressengine\Plugin\Exceptions\PluginNotFoundException;

/**
 * @category    Plugin
 * @package     Xpressengine\Plugin
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license     http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link        https://xpressengine.io
 */
class PluginScanner
{
    /**
     * @var MetaFileReader
     */
    protected $metaFileReader;

    /**
     * @var string
     */
    protected $pluginDirectory;

    /**
     * PluginScanner constructor.
     *
     * @param MetaFileReader $metaFileReader  metafile reader
     * @param string         $pluginDirectory plugin root directory
     */
    public function __construct(MetaFileReader $metaFileReader, $pluginDirectory)
    {
        $this->metaFileReader = $metaFileReader;
        $this->pluginDirectory = $pluginDirectory;
    }

    /**
     * @return string
     */
    public function getPluginDirectory()
    {
        return $this->pluginDirectory;
    }

    /**
     * 플러그인 디렉토리에 있는 모든 플러그인을 스캔하며 플러그인 정보를 수집한다.
     * 만약 특정 플러그인이 주어졌을 경우 주어진 플러그인의 정보만 수집한다.
     *
     * @param string $pluginId 정보를 수집할 플러그인 아이디
     *
     * @return array
     */
    public function scanDirectory($pluginId = null)
    {
        // scan plugin directory
        $directories = glob($this->pluginDirectory.'/'.($pluginId ?: '*'), GLOB_ONLYDIR);

        if (count($directories) === 0) {
            if ($pluginId !== null) {
                throw new PluginNotFoundException(['plugin' => $pluginId]);
            } else {
                return [];
            }
        }
        $pluginInfos = [];

        foreach ($directories as $directory) {
            $id = basename($directory);

            if (strpos($id, '_') === 0) {
                continue;
            }

            $path = $directory.'/plugin.php';

            $pluginInfo = [];
            try {
                $pluginInfo['class'] = $this->getClassName($path);
            } catch (\Exception $e) {
                continue;
            }
            $pluginInfo['id'] = $id;
            $pluginInfo['path'] = $path;
            $pluginInfo['metaData'] = $this->metaFileReader->read($directory);

            $pluginInfos[$id] = $pluginInfo;
        }

        return $pluginInfos;
    }

    /**
     * 주어진 파일에 포함된 클래스의 클래스명을 반환한다.
     *
     * @param string $file          반환할 파일의 경로
     * @param bool   $withNamespace true일 경우 네임스페이스까지 포함된 클래스명을 반환한다.
     *
     * @return string 클래스명
     */
    protected function getClassName($file, $withNamespace = true)
    {
        $tokens = token_get_all(file_get_contents($file));

        $namespace = '';
        $class = '';

        $namespaceGuess = $withNamespace ? T_NAMESPACE : false;
        $classGuess = T_CLASS;

        foreach ($tokens as $token) {
            if (!is_string($token)) {
                list($id, $text) = $token;

                if ($namespaceGuess) {
                    if ($namespaceGuess == T_NAMESPACE && $id == T_NAMESPACE) {
                        $namespaceGuess = T_STRING;
                    }

                    if ($namespaceGuess == T_STRING && $id == T_STRING) {
                        $namespace .= $text;
                        $namespaceGuess = T_NS_SEPARATOR;
                    }

                    if ($namespaceGuess == T_NS_SEPARATOR && $id == T_NS_SEPARATOR) {
                        $namespaceGuess = T_STRING;
                        $namespace .= $text;
                    }

                    // namespace ended
                    if ($namespaceGuess == T_NS_SEPARATOR && $id == T_WHITESPACE) {
                        $namespaceGuess = 0;
                    }
                }

                if ($classGuess) {
                    if ($classGuess == T_CLASS && $id == T_CLASS) {
                        $classGuess = T_STRING;
                    }

                    if ($classGuess == T_STRING && $id == T_STRING) {
                        $class .= $text;
                        break;
                    }
                }
            }
        }

        if ($class === '') {
            throw new InvaildPluginFileFormatException(['path' => $file]);
        }

        return $namespace.'\\'.$class;
    }
}
