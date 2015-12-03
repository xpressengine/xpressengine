<?php
namespace Xpressengine\Tests\Keygen;

use Xpressengine\Keygen\Keygen;

class KeygenTest extends \PHPUnit_Framework_TestCase
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
            $this->assertInstanceOf('Xpressengine\Keygen\UnknownGeneratorVersionException', $e);
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
