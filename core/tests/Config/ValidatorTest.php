<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Config;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Config\Validator;

class ValidatorTest extends TestCase
{
    public function tearDown()
    {
        m::close();
    }

    public function testValidateReturnsIlluminateValidator()
    {
        $instance = $this->getValidator();

        $config = m::mock('Xpressengine\Config\ConfigEntity');
        $config->name = 'board.instance';

        $mockValidator = m::mock('Illuminate\Validation\Validator');

        $instance->getFactory()->shouldReceive('make')->once()
            ->with(
                [
                    'name' => 'board.instance',
                    'object' => $config
                ],
                [
                    'name' => 'required|min:3|max:255',
                    'object' => 'has_parent'
                ],
                [
                    'has_parent' => 'The :attribute must be has parent'
                ]
            )->andReturn($mockValidator);

        $validator = $instance->validate($config);

        $this->assertInstanceOf('Illuminate\Validation\Validator', $validator);
    }

    private function getValidator()
    {
        list($factory) = $this->getMocks();

        $factory->shouldReceive('extend')->once()->withAnyArgs()->andReturnNull();

        return new Validator($factory);
    }

    private function getMocks()
    {
        return [
            m::mock('Illuminate\Validation\Factory')
        ];
    }
}
