<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
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
