<?php

namespace HtUserRegistrationTest\Mailer;

use HtUserRegistration\Mailer\Mailer;

class MailerTest extends \PHPUnit_Framework_TestCase
{

    protected $options;
    protected $mailerService;
    protected $mailer;
    protected $registrationRecord;
    protected $user;
    protected $message;
    protected $subject = 'Verification your email address';
    protected $template = 'application/user/verify';

    public function setUp()
    {
        $this->options = $this->getMock('HtUserRegistration\Options\ModuleOptions');

        $this->mailerService = $this->getMock('MtMail\Service\Mail', [], [], '', false);

        $this->mailer = new Mailer($this->options, $this->mailerService);

        $this->registrationRecord = $this->getMock('HtUserRegistration\Entity\UserRegistrationInterface');

        $this->user = $this->getMock('ZfcUser\Entity\UserInterface');

        $this->message = $this->getMock('Zend\Mail\Message');

        $this->registrationRecord->expects($this->once())
                ->method('getUser')
                ->will($this->returnValue($this->user));

        $this->user->expects($this->once())
                ->method('getEmail')
                ->will($this->returnValue('abc@def.com'));

        $this->mailerService->expects($this->once())
                ->method('compose')
                ->with(['to' => 'abc@def.com'], $this->template, ['user' => $this->user, 'registrationRecord' => $this->registrationRecord])
                ->will($this->returnValue($this->message));

        $this->options->expects($this->once())
                ->method('getEmailFromAddress')
                ->will($this->returnValue('ghi@jkl.com'));

        $this->message->expects($this->once())
                ->method('setFrom')
                ->with('ghi@jkl.com');

        $this->message->expects($this->once())
                ->method('setSubject')
                ->with($this->subject);

        $this->mailerService->expects($this->once())
                ->method('send')
                ->with($this->message);
    }

    public function testSendVerificationEmail()
    {
        $this->options->expects($this->once())
                ->method('getVerificationEmailSubject')
                ->will($this->returnValue($this->subject));

        $this->options->expects($this->once())
                ->method('getVerificationEmailTemplate')
                ->will($this->returnValue($this->template));

        $this->mailer->sendVerificationEmail($this->registrationRecord);
    }

    public function testPasswordRequestEmail()
    {
        $this->options->expects($this->once())
                ->method('getPasswordRequestEmailSubject')
                ->will($this->returnValue($this->subject));

        $this->options->expects($this->once())
                ->method('getPasswordRequestEmailTemplate')
                ->will($this->returnValue($this->template));

        $this->mailer->sendPasswordRequestEmail($this->registrationRecord);
    }

}
