<?php
namespace Xpressengine\Tests\Support;

class EntityTraitTest extends \PHPUnit_Framework_TestCase
{
    public function testDiffReturnsArray()
    {
        $entity = new SampleEntity(['foo' => 'bar', 'baz' => 1]);

        $diff = $entity->diff();

        $this->assertEquals(0, count($diff));

        $entity->baz = 2;
        $diff = $entity->diff();

        $this->assertEquals(['baz' => 2], $diff);

        $entity->qux = '@';
        $diff = $entity->diff();

        $this->assertEquals(['baz' => 2, 'qux' => '@'], $diff);
    }
}

class SampleEntity
{
    use \Xpressengine\Support\EntityTrait;
}
