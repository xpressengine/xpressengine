<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Skin;

use Xpressengine\Skin\AbstractSkin;

class AbstractSkinTest extends \PHPUnit\Framework\TestCase {

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testSetData()
    {
        $skin = new TestSkin();
        $data = 'data';
        $skin = $skin->setData($data);

        $skin->setView('data');

        $this->assertEquals($data, $skin->render());
    }

    public function testSetting()
    {
        $config = 'config';
        $skin = new TestSkin($config);

        $this->assertEquals($config, $skin->setting());

        $skin->setting(['config2']);
        $this->assertEquals(['config2'], $skin->setting());

    }

    public function testRender()
    {
        $skin = new TestSkin();
        $skin->setView('board.list');

        $this->assertEquals('boardList', $skin->render());
    }
}


class TestSkin extends AbstractSkin
{
    protected static $id = 'test.skin';

    protected static $supportDesktop = true;
    protected static $supportMobile = true;

    protected function boardList()
    {
        return 'boardList';
    }

    protected function data()
    {
        return $this->data;
    }

    public static function getScreenshot()
    {
        return 'screenshot';
    }

    /**
     * get settings uri
     *
     * @return string|null
     */
    public static function getSettingsURI()
    {
        return 'http://foo.bar';
    }


}
