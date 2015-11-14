<?php
/**
 *
 */
namespace Xpressengine\Tests\Document;

use Mockery as M;
use PHPUnit_Framework_TestCase;
use Xpressengine\Document\DocumentEntity;

/**
 * Class DocumentEntityTest
 * @package Xpressengine\Tests\Document
 */
class DocumentEntityTest extends PHPUnit_Framework_TestCase
{
    /**
     * tear down
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /**
     * test entity
     *
     * @return void
     */
    public function testEntity()
    {
        $entity = new DocumentEntity([
            'id' => 'id',
            'content' => 'content',
            'instanceId' => 'instanceId',
            'writer' => 'writer',
            'userId' => 'userId',
        ]);

        $this->assertEquals('id', $entity->getUid());
        $this->assertEquals('instanceId', $entity->getInstanceId());

        $this->assertEquals(DocumentEntity::CONTENT_HTML, $entity->getContentMode());
        $this->assertEquals('content', $entity->content());

        $entity->setContentMode(DocumentEntity::CONTENT_NO_HTML);
        $this->assertEquals(DocumentEntity::CONTENT_NO_HTML, $entity->getContentMode());
        $this->assertEquals('content', $entity->content());

        $this->assertEquals('content', $entity->content(DocumentEntity::CONTENT_HTML));

        $entity->setUserType(DocumentEntity::USER_TYPE_ANONYMITY);
        $entity->setUserType(DocumentEntity::USER_TYPE_GUEST);
        $entity->setUserType(DocumentEntity::USER_TYPE_USER);

        $this->assertFalse($entity->isGuest());
        $entity->setUserType(DocumentEntity::USER_TYPE_GUEST);
        $this->assertTrue($entity->isGuest());

        $this->assertEquals('writer', $entity->getWriter());
        $this->assertEquals('userId', $entity->getUserId());
    }

    /**
     * test set user
     *
     * @return void
     */
    public function testSetUser()
    {
        $entity = new DocumentEntity();

        $user = m::mock('Xpressengine\Member\Entities\Database\MemberEntity', 'Xpressengine\Member\Entities\MemberEntityInterface');
        $user->shouldReceive('getId')->andReturn('id');
        $user->shouldReceive('getDisplayName')->andReturn('name');

        /** @var \Xpressengine\Member\Entities\Database\MemberEntity $user */
        $entity->setAuthor($user);

        $this->assertEquals('id', $entity->getAuthor()->getId());
        $this->assertEquals('name', $entity->getAuthor()->getDisplayName());

        $this->assertInstanceOf('\Xpressengine\Member\Entities\MemberEntityInterface', $entity->getAuthor());
    }

    /**
     * test set guest
     *
     * @return void
     */
    public function testSetGuest()
    {
        $entity = new DocumentEntity([
            'certifyKey' => 'certifyKey',
        ]);

        $guest = m::mock('Xpressengine\Member\Entities\Guest');
        $guest->shouldReceive('getId')->andReturn('guest');
        $guest->shouldReceive('getDisplayName')->andReturn('guest');

        /** @var \Xpressengine\Member\Entities\Guest $guest */
        $entity->setAuthor($guest);
    }

    /**
     * test exception without certifyKey
     *
     * @expectedException \Xpressengine\Document\Exceptions\DocumentEntityException
     * @return void
     */
    public function testSetGuestWithoutCertifyKeyException()
    {
        $entity = new DocumentEntity([]);

        $guest = m::mock('Xpressengine\Member\Entities\Guest');
        $guest->shouldReceive('getId')->andReturn('guest');
        $guest->shouldReceive('getDisplayName')->andReturn('guest');

        /** @var \Xpressengine\Member\Entities\Guest $guest */
        $entity->setAuthor($guest);

        $entity->guest();
    }

    /**
     * test set anonymity
     *
     * @return void
     */
    public function testSetAnonymity()
    {
        $entity = new DocumentEntity();

        $user = m::mock('Xpressengine\Member\Entities\Database\MemberEntity');
        $user->shouldReceive('getId')->andReturn('id');
        $user->shouldReceive('getDisplayName')->andReturn('name');

        /** @var \Xpressengine\Member\Entities\Database\MemberEntity $user */
        $entity->anonymity('anonymity');
        $this->assertEquals('anonymity', $entity->writer);
    }

    /**
     * test permission
     *
     * @return void
     */
    public function testPermission()
    {
        $entity = new DocumentEntity();
        $entity->setUserType(DocumentEntity::USER_TYPE_GUEST);

        $guest = m::mock('Xpressengine\Member\Entities\Guest');
        $guest->shouldReceive('getId')->andReturn('guest');
        $guest->shouldReceive('getDisplayName')->andReturn('guest');

        $this->assertTrue($entity->alterPerm($guest));
        $this->assertTrue($entity->deletePerm($guest));

        $entity->setUserType(DocumentEntity::USER_TYPE_USER);
        $entity->userId = 'id';

        $this->assertFalse($entity->alterPerm($guest));
        $this->assertFalse($entity->deletePerm($guest));


        $user = m::mock('Xpressengine\Member\Entities\Database\MemberEntity');
        $user->shouldReceive('getId')->andReturn('id');
        $user->shouldReceive('getDisplayName')->andReturn('name');

        $author = m::mock('Xpressengine\Member\Entities\Database\MemberEntity');
        $author->shouldReceive('getId')->andReturn('id_author');
        $author->shouldReceive('getDisplayName')->andReturn('name_author');

        $entity->setAuthor($user);

        $this->assertFalse($entity->alterPerm($author));
        $this->assertFalse($entity->deletePerm($author));

        $this->assertTrue($entity->alterPerm($user));
        $this->assertTrue($entity->deletePerm($user));
    }

    /**
     * test change entity status attributes
     *
     * @return void
     */
    public function testSetStatus()
    {
        $entity = new DocumentEntity();

        $entity->approve();
        $this->assertEquals(DocumentEntity::APPROVED_APPROVED, $entity->approved);
        $this->assertEquals(DocumentEntity::DISPLAY_VISIBLE, $entity->display);

        $entity->reject();
        $this->assertEquals(DocumentEntity::PUBLISHED_REJECTED, $entity->approved);
        $this->assertEquals(DocumentEntity::DISPLAY_HIDDEN, $entity->display);

        $entity->approveWait();
        $this->assertEquals(DocumentEntity::PUBLISHED_WAITING, $entity->approved);
        $this->assertEquals(DocumentEntity::DISPLAY_HIDDEN, $entity->display);

        $entity->publish();
        $this->assertEquals(DocumentEntity::PUBLISHED_PUBLISHED, $entity->published);
        $this->assertEquals(DocumentEntity::DISPLAY_VISIBLE, $entity->display);

        $entity->reserve();
        $this->assertEquals(DocumentEntity::PUBLISHED_RESERVED, $entity->published);
        $this->assertEquals(DocumentEntity::DISPLAY_HIDDEN, $entity->display);

        $entity->trash();
        $this->assertEquals(DocumentEntity::STATUS_TRASH, $entity->status);

        $entity->restore();
        $this->assertEquals(DocumentEntity::STATUS_PUBLIC, $entity->status);

        $entity->temporary();
        $this->assertEquals(DocumentEntity::STATUS_TEMP, $entity->status);
        $this->assertEquals(DocumentEntity::DISPLAY_HIDDEN, $entity->display);
    }

    /**
     * test set approved exception
     *
     * @expectedException \Xpressengine\Document\Exceptions\DocumentEntityException
     * @return void
     */
    public function testSetApprovedException()
    {
        $entity = new DocumentEntity();
        $entity->setApproved('not-exists');
    }

    /**
     * test set approved exception
     *
     * @expectedException \Xpressengine\Document\Exceptions\DocumentEntityException
     * @return void
     */
    public function testSetDisplayException()
    {
        $entity = new DocumentEntity();
        $entity->setDisplay('not-exists');
    }

    /**
     * test set approved exception
     *
     * @expectedException \Xpressengine\Document\Exceptions\DocumentEntityException
     * @return void
     */
    public function testSetStatusException()
    {
        $entity = new DocumentEntity();
        $entity->setStatus('not-exists');
    }

    /**
     * test set approved exception
     *
     * @expectedException \Xpressengine\Document\Exceptions\DocumentEntityException
     * @return void
     */
    public function testSetPublishedException()
    {
        $entity = new DocumentEntity();
        $entity->setPublished('not-exists');
    }
}
