<?php
namespace Xpressengine\Tests\Member;

use Mockery;
use Xpressengine\Member\EmailBroker;

class EmailBrokerTest extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }


    public function testSendEmailForConfirmationSuccess()
    {

        $mail = Mockery::mock('\Xpressengine\Member\Entities\PendingMailEntityInterface');

        $mails = Mockery::mock('\Xpressengine\Member\Repositories\MailRepositoryInterface');
        $pendingMails = Mockery::mock('\Xpressengine\Member\Repositories\PendingMailRepositoryInterface');

        $mailer = Mockery::mock('\Illuminate\Contracts\Mail\Mailer');
        $mailer->shouldReceive('send')->with('view', compact('mail'), Mockery::type('callable'))->andReturnNull();

        $broker = new EmailBroker($mails, $pendingMails, $mailer, 'view');

        $this->assertNull($broker->sendEmailForConfirmation($mail));
    }

    public function testConfirmEmailSuccess()
    {
        $mail = Mockery::mock('\Xpressengine\Member\Entities\PendingMailEntityInterface');
        $mail->shouldReceive('getConfirmationCode')->once()->andReturn('codecode');
        $mail->shouldReceive('getAddress')->once()->andReturn('foo@gmail.com');
        $mail->shouldReceive('getMemberId')->once()->andReturn('bar');

        $mails = Mockery::mock('\Xpressengine\Member\Repositories\MailRepositoryInterface');
        $mails->shouldReceive('insert')->once()->andReturn($mail);

        $pendingMails = Mockery::mock('\Xpressengine\Member\Repositories\PendingMailRepositoryInterface');
        $pendingMails->shouldReceive('findByAddress')->once()->andReturn($mail);
        $pendingMails->shouldReceive('delete')->with($mail)->once()->andReturn(1);

        $mailer = Mockery::mock('\Illuminate\Contracts\Mail\Mailer');

        $broker = new EmailBroker($mails, $pendingMails, $mailer, 'view');

        $this->assertTrue($broker->confirmEmail('foo@gmail.com', 'codecode'));
    }

    /**
     * testConfirmEmailFailIfAlreadyEmailConfirmed
     *
     * @expectedException \Xpressengine\Member\Exceptions\PendingEmailNotExistsException
     */
    public function testConfirmEmailFailIfEmailNotExists()
    {
        $mails = Mockery::mock('\Xpressengine\Member\Repositories\MailRepositoryInterface');
        $pendingMails = Mockery::mock('\Xpressengine\Member\Repositories\PendingMailRepositoryInterface');
        $pendingMails->shouldReceive('findByAddress')->once()->andReturn(null);

        $mailer = Mockery::mock('\Illuminate\Contracts\Mail\Mailer');

        $broker = new EmailBroker($mails, $pendingMails, $mailer, 'view');

        $broker->confirmEmail('sungbum00@gmail.com', 'codecode');

    }

    /**
     * testConfirmEmailFailIfAlreadyEmailConfirmed
     *
     * @expectedException \Xpressengine\Member\Exceptions\InvalidConfirmationCodeException
     */
    public function testConfirmEmailFailIfCodeIsInvalid()
    {
        $mail = Mockery::mock('\Xpressengine\Member\Entities\PendingMailEntityInterface');
        $mail->shouldReceive('getConfirmationCode')->once()->andReturn('codecode');

        $mails = Mockery::mock('\Xpressengine\Member\Repositories\MailRepositoryInterface');

        $pendingMails = Mockery::mock('\Xpressengine\Member\Repositories\PendingMailRepositoryInterface');
        $pendingMails->shouldReceive('findByAddress')->once()->andReturn($mail);

        $mailer = Mockery::mock('\Illuminate\Contracts\Mail\Mailer');

        $broker = new EmailBroker($mails, $pendingMails, $mailer, 'view');

        $broker->confirmEmail('foo@gmail.com', 'invalid');
    }

    /**
     * testConfirmEmailFailIfAlreadyEmailConfirmed
     *
     * @expectedException \Exception
     */
    public function testConfirmEmailFailIfMailExists()
    {
        $mail = Mockery::mock('\Xpressengine\Member\Entities\PendingMailEntityInterface');
        $mail->shouldReceive('getConfirmationCode')->once()->andReturn('codecode');
        $mail->shouldReceive('getAddress')->once()->andReturn('foo@gmail.com');
        $mail->shouldReceive('getMemberId')->once()->andReturn('bar');

        $mails = Mockery::mock('\Xpressengine\Member\Repositories\MailRepositoryInterface');
        $mails->shouldReceive('insert')->once()->andThrow('\Exception');

        $pendingMails = Mockery::mock('\Xpressengine\Member\Repositories\PendingMailRepositoryInterface');
        $pendingMails->shouldReceive('findByAddress')->once()->andReturn($mail);

        $mailer = Mockery::mock('\Illuminate\Contracts\Mail\Mailer');

        $broker = new EmailBroker($mails, $pendingMails, $mailer, 'view');

        $broker->confirmEmail('foo@gmail.com', 'codecode');
    }
}
