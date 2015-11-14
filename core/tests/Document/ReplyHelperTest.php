<?php
/**
 *
 */
namespace Xpressengine\Tests\Document;

use Mockery as M;
use PHPUnit_Framework_TestCase;
use Xpressengine\Document\Repositories\ReplyHelper;
use Xpressengine\Document\Repositories\RevisionRepository;

/**
 * Class DocumentRepositoryTest
 * @package Xpressengine\Tests\Document
 */
class ReplyHelperTest extends PHPUnit_Framework_TestCase
{

    protected $replyCharLen = 3;
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
     * set up
     *
     * @return void
     */
    public function setUp()
    {
    }

    /**
     * @return M\MockInterface|\Xpressengine\Document\DocumentEntity
     */
    private function getDocumentEntity()
    {
        return m::mock('Xpressengine\Document\DocumentEntity');
    }

    /**
     * test set reply
     *
     * @return void
     */
    public function testReplyHelper()
    {
        $helper = new ReplyHelper($this->replyCharLen);

        $doc = $this->getDocumentEntity();
        $parent = $this->getDocumentEntity();
        $lastReply = 'aaa';

        $helper->setReply($doc, $parent, $lastReply);

        $this->assertEquals($doc->reply, 'aab');
        $this->assertEquals($this->replyCharLen, $helper->getReplyCharLen());
    }

}
