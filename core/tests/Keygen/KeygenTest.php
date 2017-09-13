<?php
/**
 * @author    XE Developers <developers@xpressengine.com>
 * @copyright 2015 Copyright (C) NAVER Corp. <http://www.navercorp.com>
 * @license   http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html LGPL-2.1
 * @link      https://xpressengine.io
 */

namespace Xpressengine\Tests\Keygen;

use Xpressengine\Keygen\Keygen;

class KeygenTest extends \PHPUnit\Framework\TestCase
{
    public function testGenerateReturnString()
    {
        $generator = $this->getGenerator();

        $id = $generator->generate();

        $this->assertTrue(is_string($id));
        $this->assertEquals(36, strlen($id));
    }

    public function testGenerateExceptWhenRequestUnknownVersion()
    {
        $generator = $this->getGenerator();
        $generator->setMode(6);

        try {
            $generator->generate();
            $this->assertTrue(false);
        } catch (\Exception $e) {
            $this->assertInstanceOf('Xpressengine\Keygen\Exceptions\UnknownGeneratorVersionException', $e);
        }
    }

    private function getGenerator()
    {
        return new Keygen($this->getConfig());
    }

    private function getConfig()
    {
        return [
            //'version' => 4,
            //'namespace' => 'XE.dev'
        ];
    }
}
