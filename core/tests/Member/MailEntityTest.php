<?php
namespace Xpressengine\Tests\Member;

use Xpressengine\Member\Entities\Database\MailEntity;

class MailEntityTest extends \PHPUnit_Framework_TestCase {

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $entity = new MailEntity([
            'address' => 'sungbum00@gmail.com'
        ]);

        $this->assertInstanceOf('\Xpressengine\Member\Entities\Database\MailEntity', $entity);

        return $entity;
    }

    /**
     * @depends testConstruct
     *
     * @param MailEntity $entity
     */
    public function testGetAddress($entity)
    {
        $this->assertEquals('sungbum00@gmail.com', $entity->getAddress());
        $this->assertEquals('sungbum00', $entity->getAddress(true));
    }
}
