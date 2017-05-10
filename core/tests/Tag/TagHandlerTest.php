<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Tag;

use Illuminate\Database\Eloquent\Collection;
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

        $mockTagExists1 = m::mock('Xpressengine\Tag\Tag');
        $mockTagExists1->shouldReceive('getKey')->andReturn(1);
        $mockTagExists1->shouldReceive('getAttribute')->with('word')->andReturn('laravel');
        $mockTagExists1->shouldReceive('offsetExists')->andReturn(true);
        $mockTagExists1->shouldReceive('offsetGet')->with('word')->andReturn('laravel');
        $mockTagExists2 = m::mock('Xpressengine\Tag\Tag');
        $mockTagExists2->shouldReceive('getKey')->andReturn(2);
        $mockTagExists2->shouldReceive('getAttribute')->with('word')->andReturn('cms');
        $mockTagExists2->shouldReceive('offsetExists')->andReturn(true);
        $mockTagExists2->shouldReceive('offsetGet')->with('word')->andReturn('cms');

        $repo->shouldReceive('query')->andReturnSelf();
        $repo->shouldReceive('where')->once()->with('instanceId', null)->andReturnSelf();
        $repo->shouldReceive('whereIn')->once()->with('word', ['laravel', 'cms', 'xpressengine'])->andReturnSelf();
        $repo->shouldReceive('get')->once()->andReturn(new Collection([$mockTagExists1, $mockTagExists2]));


        $decomposer->shouldReceive('execute')->once()->with('xpressengine')->andReturn('xpressengine');
        $mockTagNew = m::mock('Xpressengine\Tag\Tag');
        $mockTagNew->shouldReceive('getKey')->andReturn(5);
        $mockTagNew->shouldReceive('getAttribute')->with('word')->andReturn('xpressengine');

        $repo->shouldReceive('create')->once()->with([
            'word' => 'xpressengine',
            'decomposed' => 'xpressengine',
            'instanceId' => null,
        ])->andReturn($mockTagNew);

        $repo->shouldReceive('attach')->once()->with(
            'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            [$mockTagExists1, $mockTagExists2, $mockTagNew]
        );

        $mockTagOld1 = m::mock('Xpressengine\Tag\Tag');
        $mockTagOld1->shouldReceive('getKey')->andReturn(3);
        $mockTagOld2 = m::mock('Xpressengine\Tag\Tag');
        $mockTagOld2->shouldReceive('getKey')->andReturn(4);


        $repo->shouldReceive('detach')->once()->with(
            'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
            m::on(function ($collection) {
                $keys = [];
                foreach ($collection as $i) {
                    $keys[] = $i->getKey();
                }

                return empty(array_diff([3, 4], $keys));
            })
        );

        $repo->shouldReceive('fetchByTaggable')->once()->with('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx')->andReturn(
            new Collection([$mockTagExists1, $mockTagExists2, $mockTagOld1, $mockTagOld2])
        );

        $repo->shouldReceive('newCollection')->once()
            ->with([$mockTagExists1, $mockTagExists2, $mockTagNew])
            ->andReturn(new Collection([$mockTagExists1, $mockTagExists2, $mockTagNew]));


        $collection = $instance->set('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx', ['laravel', 'cms', 'xpressengine']);

        $keys = [];
        foreach ($collection as $item) {
            $keys[] = $item->getKey();
        }

        $this->assertEquals([1, 2, 5], $keys);
    }

    public function testSimilar()
    {
        list($repo, $decomposer) = $this->getMocks();

        $instance = $this->getMock(TagHandler::class, ['createModel'], [$repo, $decomposer]);

        $mockModel = m::mock('Xpressengine\Tag\Tag');

        $decomposer->shouldReceive('execute')->once()->with('x')->andReturn('x');
        $repo->shouldReceive('fetchSimilar')->once()->with('x', 10, 'someId')->andReturn([$mockModel]);

        $tags = $instance->similar('x', 10, 'someId');

        $this->assertInstanceOf('Xpressengine\Tag\Tag', current($tags));
    }

    private function getMocks()
    {
        return [
            m::mock('Xpressengine\Tag\TagRepository'),
            m::mock('Xpressengine\Tag\Decomposer')
        ];
    }
}
