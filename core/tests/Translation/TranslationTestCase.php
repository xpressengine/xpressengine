<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Translation;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Translation\LangData;
use Xpressengine\Translation\Translator;

class TranslationTestCase extends TestCase
{
    protected function createTranslator(array $config, array $files)
    {
        $fileLoader = $this->getLoader();
        foreach ( $files as $fileName => $data ) {
            $langData = $this->getLangData($data);
            $fileLoader->shouldReceive('load')->with($fileName)->andReturn($langData);
        }
        return new Translator($config, $this->getKeyGen(), $this->getRepo(), $fileLoader, $this->getLoader());
    }

    protected function getKeyGen()
    {
        return new \Xpressengine\Keygen\Keygen();
    }

    protected function getLangData($data)
    {
        $langData = new LangData();
        $langData->setData($data);
        return $langData;
    }

    protected function getLoader()
    {
        return m::mock(\Xpressengine\Translation\Loaders\LoaderInterface::class);
    }

    protected function getRepo()
    {
        return new RepositoryMock;
    }

    protected function getConn()
    {
        return m::mock(\Xpressengine\Database\VirtualConnectionInterface::class);
    }

    public function test() {}
}

class RepositoryMock implements \Xpressengine\Translation\Repository
{
    private $cache = [];
    public function putLangData($namespace, LangData $langData, $force = false) {
        $langData->each(function ($item, $locale, $value) use ($namespace, $force) {
            $this->putLine($namespace, $item, $locale, $value, false, $force);
        });
    }
    public function putLine($namespace, $item, $locale, $value, $multiLine = false, $force = false) {
        $this->cache[$namespace][$item][$locale] = $value;
    }
    public function getLine($namespace, $item, $locale) {
        if ( isset($this->cache[$namespace][$item][$locale]) ) {
            return $this->cache[$namespace][$item][$locale];
        }
        return null;
    }
}
