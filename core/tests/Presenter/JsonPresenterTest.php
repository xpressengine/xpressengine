<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Presenter;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Presenter\Json\JsonPresenter;

/**
 * JsonRendererTest
 * @package Xpressengine\Tests\Document
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class JsonPresenterTest extends TestCase
{
    /**
     * @var m\MockInterface|\Xpressengine\Presenter\Presenter
     */
    protected $presenter;

    /**
     * tear down
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * set up
     *
     * @return void
     */
    public function setUp()
    {
        $presenter = m::mock('Xpressengine\Presenter\Presenter');

        $this->presenter = $presenter;
    }

    /**
     * test renderer
     *
     * @return void
     */
    public function testRenderer()
    {
        $presenter = $this->presenter;
        $renderer = new JsonPresenter($presenter);

        $presenter->shouldReceive('getData')->andReturn([
            'key1' => 'value1',
            'key2' => [
                'key2-1' => 'value2-1',
                'key2-2' => 'value2-2',
            ],
        ]);

        $this->assertEquals('json', $renderer->format());
        $result = $renderer->render();
        $this->assertEquals('value1', json_decode($result, true)['key1']);
    }
}
