<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Interception;

use Xpressengine\Interception\Advisor;
use Xpressengine\Interception\InterceptionHandler;
use Xpressengine\Interception\Proxy;

class ProxyTest /*extends \PHPUnit\Framework\TestCase*/
{

    /**
     * @var InterceptionHandler
     */
    private $interceptor = null;

    /**
     * @var Proxy
     */
    private $targetObject = null;

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    protected function setUp()
    {
        $this->interceptor = InterceptionHandler::singleton(null, true);

        $this->targetObject = Document::newInstance($this->interceptor);
    }


    public function testNewProxy()
    {

        $proxy = $this->targetObject;

        $this->assertEquals(get_class($proxy->getTargetObject()), 'Xpressengine\Tests\Interception\Document');
    }

    public function testProxyCallExistMethodOfTarget()
    {
        $proxy        = $this->targetObject;
        $advisorStore = $proxy->getAdvisorCollection();

        $advisor1 = new Advisor(
            'ad1', 'Xpressengine\Tests\Interception\Document@insertDocument', function ($target, $title, $content) {
            return 'ad1('.$target($title, $content).')';
        }
        );
        $advisorStore->put($advisor1);

        $advisor2 = new Advisor(
            'ad2',
            ['Xpressengine\Tests\Interception\Document@insertDocument', 'Xpressengine\Tests\Interception\Document@checkInput'],
            function ($target, $title, $content) {
                if ($target->invokedMethod == 'insertDocument') {
                    return 'ad2('.$target($title, $content).')';
                }
                if ($target->invokedMethod == 'checkInput') {
                    $title   = 'modified '.$title.' by ad2';
                    $content = 'modified '.$content.' by ad2';
                }
                return [$title, $content];
            }
        );
        $advisorStore->put($advisor2, ['before'=>['ad1','ad3']]);

        $advisor3 = new Advisor(
            'ad3',
            'Xpressengine\Tests\Interception\Document@checkInput',
            function ($target, $title, $content) {
                return ['modified '.$title.' by ad2', 'modified '.$content.' by ad2'];
            },
            'ad1'
        );
        $advisorStore->put($advisor3, ['before'=>'ad1']);

        $ret = $proxy->insertDocument('t', 'c');

        $this->assertEquals('ad1(ad2(insertDocument("modified t by ad2", "modified c by ad2")))', $ret);
    }

    public function testProxyCallExistMethodOfTargetWithReferenceArgs()
    {

        $proxy        = $this->targetObject;
        $advisorStore = $proxy->getAdvisorCollection();

        $advisorStore->put(
            new Advisor(
                'ad1',
                'Xpressengine\Tests\Interception\Document@add',
                function ($target, $obj) {
                    $obj->title = 'modified '.$obj->title;
                    return $target($obj);
                }
            )
        );

        $obj        = new \stdClass();
        $obj->title = 'init test';
        $retObj     = $proxy->add($obj);

        $this->assertEquals($obj->title, $retObj->title);
    }

    public function testProxyCallNotExistMethodOfTargetHavingCallMagicMethod()
    {
        $proxy        = $this->targetObject;
        $advisorStore = $proxy->getAdvisorCollection();

        $advisor1 = new Advisor(
            'ad1', 'Xpressengine\Tests\Interception\Document@magicMethod',
            function ($target, $title, $content) {
                return 'ad1('.$target($title, $content).')';
            }
        );
        $advisorStore->put($advisor1);

        $advisor2 = new Advisor(
            'ad2', 'Xpressengine\Tests\Interception\Document@magicMethod',
            function ($target, $title, $content) {
                return 'ad2('.$target($title, $content).')';
            }
        );
        $advisorStore->put($advisor2);

        $ret = $proxy->magicMethod('t', 'c');

        $this->assertEquals('ad1(ad2(magicMethod(with args)))', $ret);
    }
}
