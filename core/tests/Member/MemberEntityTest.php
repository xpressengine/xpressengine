<?php
namespace Xpressengine\Tests\Member;

require_once('TestEntity.php');

use Xpressengine\Member\Entities\Database\MemberEntity;

class MemberEntityTest extends \PHPUnit_Framework_TestCase
{

    protected function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function testConstruct()
    {
        $entity = new MemberEntity();
        $this->assertInstanceOf('\Xpressengine\Member\Entities\Database\MemberEntity', $entity);
    }

    public function testConstructWithAttr()
    {
        $attr = [
            'id'=>'a',
        ];
        $entity = new MemberEntity($attr);
        $this->assertInstanceOf('\Xpressengine\Member\Entities\Database\MemberEntity', $entity);

        return $entity;
    }

    /**
     * @depends testConstructWithAttr
     *
     * @param MemberEntity $entity
     */
    public function testGetId($entity)
    {
        $this->assertEquals('a', $entity->getId());
    }

    /**
     * @depends testConstructWithAttr
     *
     * @param MemberEntity $entity
     */
    public function testGetVisibleName($entity)
    {
        $this->assertNull($entity->getDisplayName());

        $entity->name1 = 'name1';
        $entity->name2 = 'name2';
        $entity->name3 = 'name3';

        MemberEntity::$displayField = 'name1';
        $this->assertEquals('name1', $entity->getDisplayName());

        MemberEntity::$displayField = 'name2';
        $this->assertEquals('name2', $entity->getDisplayName());

        MemberEntity::$displayField = 'name3';
        $this->assertEquals('name3', $entity->getDisplayName());
    }

    /**
     * @depends testConstructWithAttr
     *
     * @param MemberEntity $entity
     */
    public function testGetProfileImage($entity)
    {
        $entity->profileImageId = '1';
        $entity::setProfileImageResolver(function($id){return $id.' image';});
        $this->assertEquals('1 image', $entity->getProfileImage());
    }

    /**
     * @depends testConstructWithAttr
     *
     * @param MemberEntity $entity
     */
    public function testGetAuthIdentifier($entity)
    {
        $this->assertEquals('a', $entity->getAuthIdentifier());
    }

    /**
     * @depends testConstructWithAttr
     *
     * @param MemberEntity $entity
     */
    public function testSetAttribute($entity)
    {
        $entity->password = 'abc';

        $attr = $this->getPropertyValue($entity, 'attributes');

        $this->assertEquals('abc', $attr['password']);

        return $entity;
    }

    /**
     * @depends testSetAttribute
     *
     * @param MemberEntity $entity
     */
    public function testGetAuthPassword($entity)
    {
        $this->assertEquals('abc', $entity->getAuthPassword());

    }

    /**
     * @depends testSetAttribute
     *
     * @param MemberEntity $entity
     */
    public function testRememberToken($entity){
        $entity->setRememberToken('abc');

        $this->assertEquals('abc', $entity->getRememberToken());

        return $entity;
    }

    /**
     * @depends testRememberToken
     *
     * @param MemberEntity $entity
     */
    public function testEmailForPasswordReset($entity){
        $entity->setEmailForPasswordReset('email');
        $this->assertEquals('email', $entity->getEmailForPasswordReset());
    }

    protected function getPropertyValue($object, $property)
    {
        $refl     = new \ReflectionObject($object);
        $repoProp = $refl->getProperty($property);
        $repoProp->setAccessible(true);
        return $repoProp->getValue($object);
    }

}
