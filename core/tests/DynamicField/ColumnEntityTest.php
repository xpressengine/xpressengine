<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\DynamicField;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Config\ColumnEntity;

/**
 * Class ColumnEntityTest
 * @package Xpressengine\Tests\DynamicField
 * @author      XE Developers <developers@xpressengine.com>
 * @copyright   2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link        https://xpressengine.io
 */
class ColumnEntityTest extends TestCase
{
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
     * test column entity
     *
     * @return void
     */
    public function testColumnEntity()
    {
        $fluent = m::mock('Illuminate\Support\Fluent');
        $fluent->shouldReceive('nullable');
        $fluent->shouldReceive('unsigned');
        $fluent->shouldReceive('default');

        $table = m::mock('Illuminate\Database\Schema\Blueprint');
        $table->shouldReceive(\Xpressengine\DynamicField\ColumnDataType::STRING)->andReturn($fluent);
        $table->shouldReceive('dropColumn');

        $column = (new \Xpressengine\DynamicField\ColumnEntity(
            'data',
            \Xpressengine\DynamicField\ColumnDataType::STRING
        ))->setParams([255]);

        $column->setUnsigned();
        $column->setNullAble();
        $column->setDefault('');
        $column->setDescription('');
        $column->add($table);
        $column->drop($table);
    }


}
