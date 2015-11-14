<?php
namespace Xpressengine\Tests\Member;

use Xpressengine\Member\Entities\Entity;

class EntityTest extends \PHPUnit_Framework_TestCase {

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }
    public function testConstruct()
    {
        $entity = new EntityForTest([
            'id' => 'khongchi',
            'name' => 'Sungbum',
            'createdAt' => '2016-12-12 12:12:12',
            'mail' => 'sungbum00@gmail.com',
            'account' => 'naver'
        ]);

        $this->assertInstanceOf('\Xpressengine\Tests\Member\TestEntity', $entity);

        return $entity;
    }

    /**
     * @depends testConstruct
     *
     * @param EntityForTest $entity
     */
    public function testGetAttribute($entity)
    {
        $this->assertEquals('khongchi', $entity->getAttribute('id'));
        $this->assertEquals('Sungbum', $entity->getAttribute('name'));
        $this->assertEquals('sungbum00@gmail.com', $entity->getAttribute('mail'));
    }

    /**
     * @depends testConstruct
     *
     * @param EntityForTest $entity
     */
    public function testGetAttributeForDateAttr($entity)
    {
        $this->assertEquals('dateType', $entity->getAttribute('createdAt'));
    }

    /**
     * @depends testConstruct
     *
     * @param EntityForTest $entity
     */
    public function testGetAttributes($entity)
    {
        $this->assertCount(3, $entity->getAttributes());
        $this->assertEquals('khongchi', $entity->getAttributes()['id']);
    }

    /**
     * @depends testConstruct
     *
     * @param EntityForTest $entity
     */
    public function testSetAttributes($entity)
    {
        $entity->setAttribute('age', 20);
        $this->assertEquals(20, $entity->getAttributes()['age']);

        return $entity;
    }

    public function testDiff()
    {
        $entity = new EntityForTest([
            'id' => 'khongchi',
            'name' => 'Sungbum',
            'createdAt' => '2016-12-12 12:12:12',
            'mail' => 'sungbum00@gmail.com',
            'account' => 'naver'
        ]);
        $entity->id = 'sungbum00';
        $entity->age = 20;

        $this->assertEquals(['id' => 'sungbum00', 'age' => 20], $entity->diff());

        return $entity;
    }

    /**
     * @depends testDiff
     *
     * @param EntityForTest $entity
     */
    public function testRaw($entity)
    {
        $this->assertEquals('khongchi', $entity->raw('id'));

        return $entity;
    }

    /**
     * @depends testRaw
     *
     * @param EntityForTest $entity
     */
    public function testSyncOriginal($entity)
    {
        $entity->syncOriginal();
        $this->assertEquals('sungbum00', $entity->raw('id'));
        return $entity;
    }

    public function testMutator()
    {
        $entity = new EntityForTest([
            'id' => 'khongchi',
            'name' => 'Sungbum',
            'gender' => 'm',
            'createdAt' => '2016-12-12 12:12:12',
            'mail' => 'sungbum00@gmail.com',
            'account' => 'naver'
        ]);
        $entity->id = 'sungbum00';
        $entity->age = 20;

        $this->assertEquals('male', $entity->gender);

        return $entity;
    }

    /**
     * @depends testMutator
     *
     * @param EntityForTest $entity
     */
    public function test__Get($entity)
    {
        $this->assertEquals('id_sungbum00', $entity->id);
    }

    public function testToArray()
    {
        $entity = new EntityForTest([
            'id' => 'khongchi',
            'name' => 'Sungbum',
            'createdAt' => '2016-12-12 12:12:12',
            'mail' => 'sungbum00@gmail.com',
            'account' => 'naver',
            'password' => 'secret'
        ]);
        $entity->id = 'sungbum00';
        $entity->age = 20;

        $arr = $entity->toArray();

        $this->assertCount(6, $arr);
        $this->assertEquals('sungbum00', $arr['id']);

        return $entity;
    }

    public function testToJson()
    {
        // TODO: implement
    }
}

class EntityForTest extends Entity
{
    protected static $relationFields = [
        'mail', 'account', 'friend'
    ];

    protected $hidden = [
        'password'
    ];
    protected function createDateAttribute($value)
    {
        return 'dateType';
    }

    protected function getGender($v)
    {
        return $v === 'm' ? 'male' : 'female';
    }

    public function getId()
    {
        return 'id_'.$this->getAttribute('id');
    }
}
