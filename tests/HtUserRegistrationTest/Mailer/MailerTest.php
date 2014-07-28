<?php
namespace HtUserRegistrationTest\Mailer;

use HtUserRegistration\Mailer\Mailer;
use HtUserRegistration\Options\ModuleOptions;

class MailerTest extends \PHPUnit_Framework_TestCase
{
    public function testSendVerificationEmail()
    {
        $options        = $this->getMock('HtUserRegistration\Options\ModuleOptions');
        $mailerService  = $this->getMock('MtMail\Service\Mail', [], [], '', false);
        $mailer = new Mailer($options, $mailerService);

        $subject = 'Verification your email address';
        $options->expects($this->once())
            ->method('getVerificationEmailSubject')
            ->will($this->returnValue($subject));

        $template = 'application/user/verify';
        $options->expects($this->once())
            ->method('getVerificationEmailTemplate')
            ->will($this->returnValue($template));

        $registrationRecord = $this->getMock('HtUserRegistration\Entity\UserRegistrationInterface');
        $user = $this->getMock('ZfcUser\Entity\UserInterface');
        $registrationRecord->expects($this->once())
            ->method('getUser')
            ->will($this->returnValue($user));

        $message = $this->getMock('Zend\Mail\Message');
        $user->expects($this->once())
            ->method('getEmail')
            ->will($this->returnValue('abc@def.com'));
        $mailerService->expects($this->once())
            ->method('compose')
            ->with(['to' => 'abc@def.com'], $template, ['user' => $user, 'registrationRecord' => $registrationRecord])
            ->will($this->returnValue($message));

        $options->expects($this->once())
            ->method('getEmailFromAddress')
            ->will($this->returnValue('ghi@jkl.com'));

        $message->expects($this->once())
            ->method('setFrom')
            ->with('ghi@jkl.com');

        $message->expects($this->once())
            ->method('setSubject')
            ->with($subject);

        $mailerService->expects($this->once())
            ->method('send')
            ->with($message);

        $mailer->sendVerificationEmail($registrationRecord);
    }
}
