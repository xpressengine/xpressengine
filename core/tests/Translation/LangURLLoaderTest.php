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
