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
        return new Translator($config, $this->getKeyGen(), $this->getCachedDB(), $fileLoader, $this->getLoader());
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

    protected function getCachedDB()
    {
        return new TransCachedDatabaseMock($this->getCache(), $this->getConn());
    }

    protected function getCache()
    {
        return new TransCacheMock(m::mock(\Illuminate\Cache\Repository::class));
    }

    protected function getConn()
    {
        return m::mock(\Xpressengine\Database\VirtualConnectionInterface::class);
    }

    public function test() {}
}

class TransCachedDatabaseMock extends \Xpressengine\Translation\TransCachedDatabase
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

class TransCacheMock extends \Xpressengine\Translation\TransCache
{
    private $cacheKey = '';
    private $cache = [];
    public function setCacheKey($transCacheKey) {
        $this->cacheKey = $transCacheKey;
    }
    public function get($namespace, $item, $locale) {
        if ( isset($this->cache[$this->cacheKey][$namespace][$item][$locale]) ) {
            return $this->cache[$this->cacheKey][$namespace][$item][$locale];
        }
        return null;
    }
    public function set($namespace, $item, $locale, $value) {
        $this->cache[$this->cacheKey][$namespace][$item][$locale] = $value;
    }
    public function flush() { $this->cache = []; }
    private function load() {}
};

