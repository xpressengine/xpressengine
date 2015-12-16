<?php
namespace Xpressengine\Tests\Translation;

use Mockery as m;
use PHPUnit_Framework_TestCase;
use Xpressengine\Translation\Loaders\LangURLLoader;

class LangURLLoaderTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testURLLoad()
    {
        $loader = new LangURLLoader();
        $loader->load('source');
    }
}
