<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2020 Copyright XEHub Corp. <https://www.xehub.io>
 * @license   http://www.gnu.org/licenses/lgpl-3.0-standalone.html LGPL
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Captcha;

use Mockery as m;
use PHPUnit\Framework\TestCase;
use Xpressengine\Captcha\Services\GoogleRecaptcha as Origin;

class GoogleRecaptchaTest extends TestCase
{
    public static $captcha;

    private static function setCaptcha()
    {
        static::$captcha = m::mock('ReCaptcha\ReCaptcha');
    }

    private static function unsetCaptcha()
    {
        static::$captcha = null;
    }

    public function setUp()
    {
        static::setCaptcha();
    }

    public function tearDown()
    {
        static::unsetCaptcha();
        m::close();
    }

    public function testVerify()
    {
        list($siteKey, $secret, $request, $frontend) = $this->getMocks();
        $instance = $this->createInstance($siteKey, $secret, $request, $frontend);

        $request->shouldReceive('get')->once()->andReturn('val');
        $request->shouldReceive('ip')->once()->andReturn('0.0.0.0');
        $request->shouldReceive('getHost')->once()->andReturn('localhost');


        $mockResponse = m::mock('ReCaptcha\Response');
        $mockResponse->shouldReceive('isSuccess')->andReturn(true);
        static::$captcha->shouldReceive('setExpectedHostname')->once()->with('localhost')->andReturnSelf();
        static::$captcha->shouldReceive('verify')->once()->with('val', '0.0.0.0')->andReturn($mockResponse);

        $result = $instance->verify();

        $this->assertTrue($result);
    }

    private function getMocks()
    {
        return [
            'siteKey',
            'secret',
            m::mock('Illuminate\Http\Request'),
            m::mock('Xpressengine\Presenter\Html\FrontendHandler'),
            m::mock('ReCaptcha\ReCaptcha')
        ];
    }

    private function createInstance($siteKey, $secret, $request, $frontend)
    {
        return new GoogleRecaptcha($siteKey, $secret, $request, $frontend);
    }
}


class GoogleRecaptcha extends Origin
{
    protected function create()
    {
        return $this->captcha = GoogleRecaptchaTest::$captcha;
    }
}
