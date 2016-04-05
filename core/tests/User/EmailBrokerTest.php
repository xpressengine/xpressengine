<?php
namespace Xpressengine\Tests\User;

use Illuminate\Contracts\Mail\Mailer;
use Mockery;
use Xpressengine\User\EmailBroker;
use Xpressengine\User\EmailInterface;
use Xpressengine\User\UserHandler;

class EmailBrokerTest extends \PHPUnit_Framework_TestCase
{
    protected function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }


    public function testSendEmailForConfirmationSuccess()
    {
        $mail = Mockery::mock(EmailInterface::class);
        $mail->shouldReceive('getAddress')->once()->andReturnSelf();

        $message = Mockery::mock(\Illuminate\Mail\Message::class);
        $message->shouldReceive('to')->once()->with($mail)->andReturnNull();

        /** @var UserHandler $userHandler */
        $userHandler = $this->makeHandler();

        $validator = function($callable) use ($message) {
            $callable($message);
            return true;
        };

        /** @var Mailer $mailer */
        $mailer = $this->makeMailer();
        $mailer->shouldReceive('send')->with('view', compact('mail'), Mockery::on($validator))->andReturnNull();

        $broker = new EmailBroker($userHandler, $mailer, 'view');

        $this->assertNull($broker->sendEmailForConfirmation($mail));
    }

    public function testConfirmEmailSuccess()
    {
        $address = 'foo@gmail.com';
        $mail = Mockery::mock(EmailInterface::class);
        $mail->shouldReceive('getConfirmationCode')->once()->andReturn('codecode');
        $mail->shouldReceive('getAddress')->once()->andReturn($address);
        $user = $this->makeUser();
        $mail->user = $user;

        $userHandler = $this->makeHandler();
        $userHandler->shouldReceive('createEmail')->once()->with($user, compact('address'), true)->andReturnNull();
        $userHandler->shouldReceive('deleteEmail')->once()->with($mail)->andReturnNull();

        /** @var Mailer $mailer */
        $mailer = $this->makeMailer();

        /** @var UserHandler $userHandler */
        $broker = new EmailBroker($userHandler, $mailer, 'view');

        $this->assertTrue($broker->confirmEmail($mail, 'codecode'));
    }

    /**
     * testConfirmEmailFailIfAlreadyEmailConfirmed
     *
     * @expectedException \Xpressengine\User\Exceptions\InvalidConfirmationCodeException
     */
    public function testConfirmEmailFailIfCodeIsInvalid()
    {
        $address = 'foo@gmail.com';
        $mail = Mockery::mock(EmailInterface::class);
        $mail->shouldReceive('getConfirmationCode')->once()->andReturn('codecode');

        $userHandler = $this->makeHandler();

        /** @var Mailer $mailer */
        $mailer = $this->makeMailer();

        /** @var UserHandler $userHandler */
        $broker = new EmailBroker($userHandler, $mailer, 'view');

        $this->assertTrue($broker->confirmEmail($mail, 'wrongcode'));
    }

    /**
     * makeHandler
     *
     * @return Mockery\Mock
     */
    protected function makeHandler()
    {
        return Mockery::mock(\Xpressengine\User\UserHandler::class);
    }

    protected function makeMailer()
    {
        return Mockery::mock(\Illuminate\Contracts\Mail\Mailer::class);
    }

    /**
     * makeUser
     *
     * @return Mockery\MockInterface
     */
    private function makeUser()
    {
        return Mockery::mock(\Xpressengine\User\Models\User::class);
    }

}
