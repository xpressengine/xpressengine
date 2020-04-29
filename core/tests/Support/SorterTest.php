<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Support;

use Xpressengine\Support\Sorter;

class SorterTest extends \PHPUnit\Framework\TestCase
{

    /**
     * @var SorterStub
     */
    protected $sorter;

    public function testSortSimple()
    {
        $this->sorter->add('2', Sorter::AFTER, '1');
        $this->sorter->add('3', Sorter::BEFORE, '1');
        $this->sorter->add('1', Sorter::AFTER, '3');
        $this->sorter->add('4', Sorter::AFTER, '1');

        $list = $this->sorter->sort();

        $this->assertEquals(
            ['2', '4', '1', '3'], $list
        );
    }

    public function testSortComplex()
    {
        // 2 6 4 3 5 1
        $this->sorter->add('2', Sorter::AFTER, '6');
        $this->sorter->add('4', Sorter::AFTER, '3');
        $this->sorter->add('2', Sorter::AFTER, '3');
        $this->sorter->add('3', Sorter::AFTER, '5');
        $this->sorter->add('6', Sorter::AFTER, '4');

        $this->sorter->add('1', Sorter::BEFORE, '6');
        $this->sorter->add('1', Sorter::BEFORE, '5');
        $this->sorter->add('5', Sorter::BEFORE, '4');


        $this->assertEquals(
            [],
            array_diff($this->sorter->tails, ['1', '2', '3', '4', '5', '6'])
        );
        $this->assertEquals(6, count($this->sorter->tails));

        $list = $this->sorter->sort();

        $this->assertEquals(
            ['2', '6', '4', '3', '5', '1'], $list
        );
    }

    public function testSortOmittedKey()
    {
        // 2 6 4 3 5 1
        $this->sorter->add('2', Sorter::AFTER, '6');
        $this->sorter->add('4', Sorter::AFTER, '3');
        $this->sorter->add('2', Sorter::AFTER, '3');
        $this->sorter->add('3', Sorter::AFTER, '5');

        //$this->sorter->add('6', Sorter::AFTER, '4'); deleted

        $this->sorter->add('1', Sorter::BEFORE, '6');
        $this->sorter->add('1', Sorter::BEFORE, '5');
        $this->sorter->add('5', Sorter::BEFORE, '4');
        $this->sorter->add('5', Sorter::BEFORE, '3');

        $this->assertEquals(
            [],
            array_diff($this->sorter->tails, ['1', '2', '3', '4', '5'])
        );
        $this->assertEquals(5, count($this->sorter->tails));


        $list = $this->sorter->sort();

        $this->assertEquals(
            ['2', '4', '3', '5', '1'], $list
        );
    }

    public function testSortUsingArray()
    {
        // 2 6 4 3 5 1
        $this->sorter->add(['6', '5'], Sorter::BEFORE, '2');
        $this->sorter->add('1', Sorter::BEFORE, '5');

        $this->sorter->add(['2', '6'], Sorter::AFTER, '4');
        $this->sorter->add(['3', '6', '4'], Sorter::AFTER, '5');
        $this->sorter->add('4', Sorter::AFTER, '3');

        $list = $this->sorter->sort();

        // 3 5 1 4 2

        $this->assertEquals(
            ['2', '6', '4', '3', '5', '1'], $list
        );
    }

    public function testSortUsingComplexArray()
    {
        // 2 6 4 3 5 1
        $this->sorter->add(['6', '5'], Sorter::BEFORE, '2');
        $this->sorter->add('1', Sorter::BEFORE, ['3', '5']);
        $this->sorter->add('5', Sorter::BEFORE, '3');

        $this->sorter->add(['2', '6'], Sorter::AFTER, '4');
        $this->sorter->add(['6', '4'], Sorter::AFTER, '5');
        $this->sorter->add('4', Sorter::AFTER, '3');

        $list = $this->sorter->sort();

        // 3 5 1 4 2

        $this->assertEquals(
            ['2', '6', '4', '5', '1'], $list
        );
    }

    public function testSortUsingArrayTarget()
    {
        // 2 6 4 3 5 1
        $this->sorter->add('2', Sorter::AFTER, ['3', '6']);
        $this->sorter->add('4', Sorter::AFTER, '3');
        $this->sorter->add('3', Sorter::AFTER, '5');
        $this->sorter->add('6', Sorter::AFTER, '4');

        $this->sorter->add('1', Sorter::BEFORE, ['5', '6']);
        $this->sorter->add('5', Sorter::BEFORE, '4');

        $this->assertEquals(
            [],
            array_diff($this->sorter->tails, ['1', '2', '3', '4', '5', '6'])
        );
        $this->assertEquals(6, count($this->sorter->tails));


        $list = $this->sorter->sort();

        $this->assertEquals(
            ['2', '6', '4', '3', '5', '1'], $list
        );
    }

    /**
     * @expectedException \Xpressengine\Support\InfiniteRecursionException
     */
    public function testSortRecursionException()
    {
        // 2 6 4 3 5 1
        $this->sorter->add('2', Sorter::BEFORE, '1');
        $this->sorter->add('3', Sorter::BEFORE, '2');
        $this->sorter->add('1', Sorter::BEFORE, '3');
        $this->sorter->add('4', Sorter::BEFORE, '3');

        $list = $this->sorter->sort();
    }

    public function testReSort()
    {
        $this->sorter->add('2', Sorter::AFTER, '1');
        $this->sorter->add('3', Sorter::BEFORE, '1');
        $this->sorter->add('1', Sorter::AFTER, '3');
        $this->sorter->add('4', Sorter::AFTER, '1');

        $list = $this->sorter->sort();

        $this->assertEquals(
            ['2', '4', '1', '3'], $list
        );

        $list = $this->sorter->sort();

        $this->assertEquals(
            ['2', '4', '1', '3'], $list
        );
    }

    public function testSortWithKeyList()
    {
        $this->sorter->add('2', Sorter::AFTER, '1');
        $this->sorter->add('3', Sorter::BEFORE, '1');
        $this->sorter->add('1', Sorter::AFTER, '3');
        $this->sorter->add('4', Sorter::AFTER, '1');

        $list = $this->sorter->sort();

        $this->assertEquals(
            ['2', '4', '1', '3'], $list
        );

        $list = $this->sorter->sort(['1','2','3']);

        $this->assertEquals(
            ['2', '1', '3'], $list
        );
    }

    public function testSortWithKeyListComplex()
    {
        // 2 6 4 3 5 1
        $this->sorter->add(['6', '5'], Sorter::BEFORE, '2');
        $this->sorter->add('1', Sorter::BEFORE, ['3', '5']);
        $this->sorter->add('5', Sorter::BEFORE, '3');

        $this->sorter->add(['2', '6'], Sorter::AFTER, '4');
        $this->sorter->add(['6', '4'], Sorter::AFTER, '5');
        $this->sorter->add('4', Sorter::AFTER, '3');

        $list = $this->sorter->sort(['1','2','4']);

        // 3 5 1 4 2

        $this->assertEquals(
            ['2', '4', '1'], $list
        );

        $list = $this->sorter->sort();

        // 3 5 1 4 2

        $this->assertEquals(
            ['2', '6', '4', '5', '1'], $list
        );
    }









    protected function setUp()
    {
        $this->sorter = new SorterStub();
        parent::setUp();
    }
}

class SorterStub extends Sorter
{

    public $relations = [];

    public $befores = [];

    public $sortedKeys = [];

    public $tails = [];
}
