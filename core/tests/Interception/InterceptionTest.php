<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Interception;

use Xpressengine\Interception\InterceptionHandler;

class InterceptionTest /*extends \PHPUnit\Framework\TestCase*/
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testInterceptionTest()
    {

        // recreate interceptor
        $interceptor = InterceptionHandler::singleton(null, true);

        $interceptor->addAdvisor(
            'Xpressengine\Tests\Interception\Document@insertDocument',
            'ad1',
            function ($target, $title, $content) {
                return 'ad1('.$target($title, $content).')';
            }
        );
        $interceptor->addAdvisor(
            ['Xpressengine\Tests\Interception\Document@insertDocument', 'Xpressengine\Tests\Interception\Document@checkInput'],
            ['ad2' => ['ad1', 'ad3']],
            function ($target, $title, $content) {
                if ($target->invokedMethod == 'insertDocument') {
                    return 'ad2('.$target($title, $content).')';
                }
                if ($target->invokedMethod == 'checkInput') {
                    $title   = 'modified '.$title.' by ad2';
                    $content = 'modified '.$content.' by ad2';

                    return [$title, $content];
                }
            }
        );

        $document = Document::newInstance();

        $t   = 't';
        $c   = 'c';
        $ret = $document->insertDocument($t, $c);

        $this->assertEquals('ad1(ad2(insertDocument("modified t by ad2", "modified c by ad2")))', $ret);
    }

    public function testInterceptionTestAfter()
    {

        // recreate interceptor
        $interceptor = InterceptionHandler::singleton(null, true);

        $interceptor->addAdvisor(
            ['Xpressengine\Tests\Interception\Document@insertDocument', 'Xpressengine\Tests\Interception\Document@checkInput'],
            ['ad2' => ['ad3']],
            function ($target, $title, $content) {
                if ($target->invokedMethod == 'insertDocument') {
                    return 'ad2('.$target($title, $content).')';
                }
                if ($target->invokedMethod == 'checkInput') {
                    $title   = 'modified '.$title.' by ad2';
                    $content = 'modified '.$content.' by ad2';

                    return [$title, $content];
                }
            }
        );
        $interceptor->addAdvisor(
            'Xpressengine\Tests\Interception\Document@insertDocument',
            ['ad1' => ['after' => 'ad2']],
            function ($target, $title, $content) {
                return 'ad1('.$target($title, $content).')';
            }
        );

        $document = Document::newInstance();

        $t   = 't';
        $c   = 'c';
        $ret = $document->insertDocument($t, $c);

        $this->assertEquals('ad1(ad2(insertDocument("modified t by ad2", "modified c by ad2")))', $ret);
    }
}
