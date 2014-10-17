<?php

namespace HtUserRegistrationTest\Authentication\Adapter;

use HtUserRegistration\Authentication\Adapter\EmailVerification;
use Zend\Authentication\Result as AuthenticationResult;

class EmailVerificationTest extends \PHPUnit_Framework_TestCase
{

    protected $userRegistrationMapper;
    protected $user;
    protected $userMapper;
    protected $zfcUser;
    protected $identity;
    protected $emailVerification;
    protected $event;

    public function setUp()
    {
        $this->userRegistrationMapper = $this->getMock('HtUserRegistration\Mapper\UserRegistrationMapperInterface');
        $this->user = $this->getMock('HtUserRegistration\Entity\UserRegistrationInterface');
        $this->userMapper = $this->getMock('ZfcUser\Mapper\UserInterface');
        $this->zfcUser = $this->getMock('ZfcUser\Entity\UserInterface');
        $this->identity = $this->getMock('ZfcUser\Controller\Plugin\ZfcUserAuthentication');
        $this->event = $this->getMock('ZfcUser\Authentication\Adapter\AdapterChainEvent');

        $this->emailVerification = new EmailVerification($this->userRegistrationMapper, $this->userMapper);
    }

    public function testAuthenticateNoIdentity()
    {
        $this->event->expects($this->once())
                ->method('getIdentity')
                ->willReturn(null);

        $this->assertFalse($this->emailVerification->authenticate($this->event));
    }

    public function testAuthenticateNoRecord()
    {
        $this->event->expects($this->any())
                ->method('getIdentity')
                ->willReturn($this->identity);
        $this->event->expects($this->once())
                ->method('setCode')
                ->with(AuthenticationResult::FAILURE)
                ->willReturn($this->event);
        $this->event->expects($this->once())
                ->method('setMessages')
                ->with(array('Email Address not verified yet'));

        $this->userMapper->expects($this->once())
                ->method('findById')
                ->with($this->identity)
                ->willReturn($this->zfcUser);

        $this->userRegistrationMapper->expects($this->once())
                ->method('findByUser')
                ->with($this->zfcUser)
                ->willReturn(null);

        $this->assertFalse($this->emailVerification->authenticate($this->event));
    }

    public function testAuthenticateResponded()
    {
        $this->event->expects($this->any())
                ->method('getIdentity')
                ->willReturn($this->identity);
        $this->event->expects($this->once())
                ->method('setCode')
                ->with(AuthenticationResult::FAILURE)
                ->willReturn($this->event);
        $this->event->expects($this->once())
                ->method('setMessages')
                ->with(array('Email Address not verified yet'));

        $this->userMapper->expects($this->once())
                ->method('findById')
                ->with($this->identity)
                ->willReturn($this->zfcUser);

        $this->user->expects($this->once())
                ->method('isResponded')
                ->willReturn(false);

        $this->userRegistrationMapper->expects($this->once())
                ->method('findByUser')
                ->with($this->zfcUser)
                ->willReturn($this->user);

        $this->assertFalse($this->emailVerification->authenticate($this->event));
    }

    public function testAuthenticateSuccessfull()
    {
        $this->event->expects($this->any())
                ->method('getIdentity')
                ->willReturn($this->identity);

        $this->userMapper->expects($this->once())
                ->method('findById')
                ->with($this->identity)
                ->willReturn($this->zfcUser);

        $this->user->expects($this->once())
                ->method('isResponded')
                ->willReturn(true);

        $this->userRegistrationMapper->expects($this->once())
                ->method('findByUser')
                ->with($this->zfcUser)
                ->willReturn($this->user);

        $this->assertTrue($this->emailVerification->authenticate($this->event));
    }

}
