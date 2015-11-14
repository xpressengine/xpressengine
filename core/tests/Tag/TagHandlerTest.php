<?php
namespace Xpressengine\Tests\Tag;

use Mockery as m;
use Xpressengine\Tag\TagHandler;

class TagHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testSet()
    {
        list($repo, $decomposer) = $this->getMocks();

        $instance = new TagHandler($repo, $decomposer);

        $entity1 = m::mock('Xpressengine\Tag\TagEntity');
        $entity1->id = 1;
        $entity2 = m::mock('Xpressengine\Tag\TagEntity');
        $entity2->id = 2;
        $entity3 = m::mock('Xpressengine\Tag\TagEntity');
        $entity3->id = 3;
        $entity4 = m::mock('Xpressengine\Tag\TagEntity');
        $entity4->id = 4;

        $repo->shouldReceive('hasMany')->once()->with('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturn([$entity1, $entity2]);
        $repo->shouldReceive('findByInstanceIdAndWord')->once()->with('freeboard', 'laravel')->andReturnNull();
        $repo->shouldReceive('findByInstanceIdAndWord')->once()->with('freeboard', 'cms')->andReturnNull();
        $repo->shouldReceive('findByInstanceIdAndWord')->once()->with('freeboard', 'xpressengine')->andReturn($entity1);

        $decomposer->shouldReceive('execute')->once()->with('laravel')->andReturn('laravel');
        $decomposer->shouldReceive('execute')->once()->with('cms')->andReturn('cms');

        $repo->shouldReceive('insert')->once()->withAnyArgs()->andReturn($entity3);
        $repo->shouldReceive('insert')->once()->withAnyArgs()->andReturn($entity4);

        $repo->shouldReceive('existsUsed')->once()->with('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', $entity3)->andReturn(false);
        $repo->shouldReceive('insertUsed')->once()->with('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', $entity3)->andReturnNull();
        $repo->shouldReceive('increment')->once()->with($entity3)->andReturnNull();

        $repo->shouldReceive('existsUsed')->once()->with('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', $entity4)->andReturn(false);
        $repo->shouldReceive('insertUsed')->once()->with('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', $entity4)->andReturnNull();
        $repo->shouldReceive('increment')->once()->with($entity4)->andReturnNull();

        $repo->shouldReceive('existsUsed')->once()->with('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', $entity1)->andReturn(true);

        $repo->shouldReceive('existsUsed')->once()->with('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', $entity2)->andReturn(true);
        $repo->shouldReceive('deleteUsed')->once()->with('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', $entity2)->andReturnNull();
        $repo->shouldReceive('decrement')->once()->with($entity2)->andReturnNull();


        $instance->set('freeboard', 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', ['laravel', 'cms', 'xpressengine']);
    }

    public function testAutoCompletion()
    {
        list($repo, $decomposer) = $this->getMocks();

        $instance = new TagHandler($repo, $decomposer);

        $entity1 = m::mock('Xpressengine\Tag\TagEntity');
        $entity1->word = 'apple';
        $entity2 = m::mock('Xpressengine\Tag\TagEntity');
        $entity2->word = 'application';

        $decomposer->shouldReceive('execute')->once()->with('ap')->andReturn('ap');
        $repo->shouldReceive('fetchSimilar')->once()->with('ap', null, 15)->andReturn([$entity1, $entity2]);

        $tags = $instance->autoCompletion('ap', null, 15);

        $this->assertEquals(2, count($tags));
        $this->assertEquals('apple', $tags[0]->word);
        $this->assertEquals('application', $tags[1]->word);
    }

    public function testPopular()
    {
        list($repo, $decomposer) = $this->getMocks();

        $instance = new TagHandler($repo, $decomposer);

        $entity1 = m::mock('Xpressengine\Tag\TagEntity');
        $entity2 = m::mock('Xpressengine\Tag\TagEntity');
        $entity3 = m::mock('Xpressengine\Tag\TagEntity');

        $repo->shouldReceive('popular')->once()->with('freeboard', null, null, 3)->andReturn([$entity1, $entity2, $entity3]);

        $tags = $instance->popular('freeboard', null, null, 3);

        $this->assertEquals(3, count($tags));
    }

    public function testCount()
    {
        list($repo, $decomposer) = $this->getMocks();

        $instance = new TagHandler($repo, $decomposer);

        $repo->shouldReceive('count')->once()->with('freeboard', 'pop', null, null)->andReturn(3);

        $count = $instance->count('freeboard', 'pop', null, null);

        $this->assertEquals(3, $count);
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Tag\TagRepository'),
            m::mock('Xpressengine\Tag\Decomposer')
        ];
    }
}
