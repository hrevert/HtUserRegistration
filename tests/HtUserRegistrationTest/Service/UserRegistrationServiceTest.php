<?php

namespace HtUserRegistrationTest\Service;

use HtUserRegistration\Service\UserRegistrationService;
use HtUserRegistration\Entity\UserRegistration;

class UserRegistrationServiceTest extends \PHPUnit_Framework_TestCase
{

    protected $userRegistrationMapper;
    protected $userRegistrationEntity;
    protected $userRegistrationOptions;
    protected $userRegistrationMailer;
    protected $zfcUserMapper;
    protected $zfcUserOptions;
    protected $zfcUserEntity;
    protected $event;
    protected $userRegistrationService;

    public function setUp()
    {
        $this->userRegistrationMapper = $this->getMock('HtUserRegistration\Mapper\UserRegistrationMapperInterface');
        $this->userRegistrationEntity = $this->getMock('HtUserRegistration\Entity\UserRegistrationInterface');
        $this->userRegistrationOptions = $this->getMock('HtUserRegistration\Options\ModuleOptions');
        $this->userRegistrationMailer = $this->getMock('HtUserRegistration\Mailer\MailerInterface');

        $this->zfcUserMapper = $this->getMock('ZfcUser\Mapper\UserInterface');
        $this->zfcUserOptions = $this->getMock('ZfcUser\Options\ModuleOptions');
        $this->zfcUserEntity = $this->getMock('ZfcUser\Entity\UserInterface');

        $this->event = $this->getMock('Zend\EventManager\EventInterface');

        $this->userRegistrationService = new UserRegistrationService($this->userRegistrationMapper, $this->userRegistrationOptions, $this->userRegistrationMailer, $this->zfcUserMapper, $this->zfcUserOptions);
    }

    /**
     * invoked via onUserRegistration
     */
    public function testSendVerificationEmail()
    {
        $this->event->expects($this->once())
                ->method('getParam')
                ->with('user')
                ->will($this->returnValue($this->zfcUserEntity));

        $this->userRegistrationOptions->expects($this->once())
                ->method('getRegistrationEntityClass')
                ->will($this->returnValue('HtUserRegistration\Entity\UserRegistration'));

        $this->userRegistrationOptions->expects($this->once())
                ->method('getSendVerificationEmail')
                ->will($this->returnValue(true));

        $this->zfcUserOptions->expects($this->once())
                ->method('getEnableRegistration')
                ->will($this->returnValue(true));

        $this->userRegistrationMailer->expects($this->once())
                ->method('sendVerificationEmail');

        $this->userRegistrationService->onUserRegistration($this->event);
    }

    /**
     * invoked via onUserRegistration
     */
    public function testSendPasswordRequestEmail()
    {
        $this->event->expects($this->once())
                ->method('getParam')
                ->with('user')
                ->will($this->returnValue($this->zfcUserEntity));

        $this->userRegistrationOptions->expects($this->once())
                ->method('getSendPasswordRequestEmail')
                ->will($this->returnValue(true));

        $this->zfcUserOptions->expects($this->once())
                ->method('getEnableRegistration')
                ->will($this->returnValue(false));

        $this->userRegistrationOptions->expects($this->once())
                ->method('getRegistrationEntityClass')
                ->will($this->returnValue('HtUserRegistration\Entity\UserRegistration'));

        $this->userRegistrationMailer->expects($this->once())
                ->method('sendPasswordRequestEmail');

        $this->userRegistrationService->onUserRegistration($this->event);
    }

    public function testVerifyEmailNoRecord()
    {
        $token = "token";

        $this->userRegistrationMapper->expects($this->once())
                ->method('findByUser')
                ->with($this->zfcUserEntity)
                ->will($this->returnValue(null));

        $this->assertFalse($this->userRegistrationService->verifyEmail($this->zfcUserEntity, $token));
    }

    public function testVerifyEmailInvalidToken()
    {
        $validToken = "validToken";
        $entityToken = "invalidToken";

        $this->userRegistrationEntity->expects($this->once())
                ->method('getToken')
                ->will($this->returnValue($entityToken));

        $this->userRegistrationMapper->expects($this->once())
                ->method('findByUser')
                ->with($this->zfcUserEntity)
                ->will($this->returnValue($this->userRegistrationEntity));

        $this->assertFalse($this->userRegistrationService->verifyEmail($this->zfcUserEntity, $validToken));
    }

    public function testVerifyEmailSuccessfull()
    {
        $validToken = "validToken";
        $entityToken = "validToken";

        $this->userRegistrationEntity->expects($this->once())
                ->method('getToken')
                ->will($this->returnValue($entityToken));

        $this->userRegistrationEntity->expects($this->once())
                ->method('isResponded')
                ->will($this->returnValue(false));

        $this->userRegistrationEntity->expects($this->once())
                ->method('setResponded')
                ->with(UserRegistration::EMAIL_RESPONDED);

        $this->userRegistrationMapper->expects($this->once())
                ->method('findByUser')
                ->with($this->zfcUserEntity)
                ->will($this->returnValue($this->userRegistrationEntity));

        $this->userRegistrationMapper->expects($this->once())
                ->method('update')
                ->with($this->userRegistrationEntity);

        $this->assertTrue($this->userRegistrationService->verifyEmail($this->zfcUserEntity, $validToken));
    }

    public function testIsTokenValidWrongToken()
    {
        $validToken = "validToken";
        $entityToken = "invalidToken";

        $this->userRegistrationEntity->expects($this->once())
                ->method('getToken')
                ->will($this->returnValue($entityToken));

        $this->assertFalse($this->userRegistrationService->isTokenValid($this->zfcUserEntity, $validToken, $this->userRegistrationEntity));
    }

    public function testIsTokenValidExpiredToken()
    {
        $validToken = "validToken";
        $entityToken = "validToken";

        $this->userRegistrationEntity->expects($this->once())
                ->method('getToken')
                ->will($this->returnValue($entityToken));

        $this->userRegistrationOptions->expects($this->once())
                ->method('getEnableRequestExpiry')
                ->will($this->returnValue(true));

        $this->userRegistrationOptions->expects($this->once())
                ->method('getRequestExpiry')
                ->will($this->returnValue(86400));

        $this->userRegistrationEntity->expects($this->once())
                ->method('getRequestTime')
                ->will($this->returnValue(new \DateTime('25 hours ago')));

        $this->assertFalse($this->userRegistrationService->isTokenValid($this->zfcUserEntity, $validToken, $this->userRegistrationEntity));
    }

    public function testIsTokenValidSuccessfull()
    {
        $validToken = "validToken";
        $entityToken = "validToken";

        $this->userRegistrationEntity->expects($this->once())
                ->method('getToken')
                ->will($this->returnValue($entityToken));

        $this->userRegistrationOptions->expects($this->once())
                ->method('getEnableRequestExpiry')
                ->will($this->returnValue(true));

        $this->userRegistrationOptions->expects($this->once())
                ->method('getRequestExpiry')
                ->will($this->returnValue(86400));

        $this->userRegistrationEntity->expects($this->once())
                ->method('getRequestTime')
                ->will($this->returnValue(new \DateTime('23 hours ago')));

        $this->assertTrue($this->userRegistrationService->isTokenValid($this->zfcUserEntity, $validToken, $this->userRegistrationEntity));
    }

    public function testIsTokenExpired()
    {
        $this->userRegistrationOptions->expects($this->any())
                ->method('getRequestExpiry')
                ->will($this->returnValue(86400));

        $entity = new UserRegistration;
        $entity->setRequestTime(new \DateTime('25 hours ago'));
        $this->assertEquals(true, $this->userRegistrationService->isTokenExpired($entity));
        $entity->setRequestTime(new \DateTime('23 hours ago'));
        $this->assertEquals(false, $this->userRegistrationService->isTokenExpired($entity));
    }

    public function testSetPassword()
    {
        $password = '1a2b3c';
        $data['newCredential'] = $password;

        $this->zfcUserEntity->expects($this->once())
                ->method('setPassword');

        $this->userRegistrationEntity->expects($this->once())
                ->method('getUser')
                ->will($this->returnValue($this->zfcUserEntity));

        $this->userRegistrationEntity->expects($this->once())
                ->method('setResponded')
                ->with(UserRegistration::EMAIL_RESPONDED);

        $this->zfcUserMapper->expects($this->once())
                ->method('update')
                ->with($this->zfcUserEntity);

        $this->userRegistrationMapper->expects($this->once())
                ->method('update')
                ->with($this->userRegistrationEntity);

        $this->userRegistrationService->setPassword($data, $this->userRegistrationEntity);
    }

}
