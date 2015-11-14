<?php

use Mockery as m;
use Xpressengine\Translation\LangData;
use Xpressengine\Translation\Loaders\LangFileLoader;

class LangFileLoaderTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testFileLoad()
    {
        $fileSystem = $this->getFileSystem();
        $fileSystem->shouldReceive('getRequire')->with('groupKey')->andReturn(['xe' => 'cms']);

        $loader = new LangFileLoader($fileSystem);
        $this->assertNotNull($loader->load('groupKey'));
    }

    protected function getFileSystem()
    {
        return m::mock('Illuminate\Filesystem\Filesystem');
    }
}
