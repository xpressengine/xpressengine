<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Translation;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Translation\Loaders\LangURLLoader;

class LangURLLoaderTest extends TestCase
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
