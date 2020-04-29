<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Frontend;

use Xpressengine\Presenter\Html\Tags\BodyClass;

class BodyClassTest extends \PHPUnit\Framework\TestCase {

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $tag = new BodyClass('sm');

        $refl = new \ReflectionObject($tag);
        $class = $refl->getProperty('class');
        $class->setAccessible(true);

        $this->assertEquals('sm', $class->getValue($tag));

        return $tag;
    }

    /**
     * @depends testConstruct
     */
    public function testOutputSimple(BodyClass $tag)
    {
        $output = BodyClass::output();

        $this->assertEquals('sm', $output);
    }

    public function testUnload()
    {
        $tag1 = new BodyClass('sm');
        $tag2 = new BodyClass('md');

        $output = BodyClass::output();

        $this->assertEquals('sm md', $output);
        $tag2->unload();

        $output = BodyClass::output();

        $this->assertEquals('sm', $output);
    }
}
