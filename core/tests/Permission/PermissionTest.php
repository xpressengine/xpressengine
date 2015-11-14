<?php
namespace Xpressengine\Tests\Permission;

use Mockery as m;
use Xpressengine\Permission\Permission;
use Xpressengine\Permission\Action;

class PermissionTest extends \PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testAblesThrownExceptionWhenNotSupported()
    {
        $mockUser = m::mock('Xpressengine\Member\Entities\Guest');

        $instance = new SamplePermission('some.target', $mockUser);

        try {
            $instance->ables(Action::CREATE);

            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Permission\Exceptions\NotSupportedException', $e);
        }
    }

    public function testAblesCallFuncIfGivenCallable()
    {
        $mockUser = m::mock('Xpressengine\Member\Entities\Guest');

        $instance = new SamplePermission('some.target', $mockUser);

        $result = $instance->ables(Action::READ, function ($target, $user) {
            return $user instanceof \Xpressengine\Member\Entities\Guest;
        });

        $this->assertTrue($result);
    }

    public function testUnablesReturnsDifferentResultFromAbles()
    {
        $mockUser = m::mock('Xpressengine\Member\Entities\Guest');

        $instance = new SamplePermission('some.target', $mockUser);

        $this->assertTrue($instance->ables(Action::READ));
        $this->assertFalse($instance->unables(Action::READ));
    }
}

class SamplePermission extends Permission
{
    protected $actions = [Action::READ];

    public function __construct($target, $user)
    {
        $this->target = $target;
        $this->user = $user;
    }

    protected function judge($action)
    {
        return true;
    }
}
