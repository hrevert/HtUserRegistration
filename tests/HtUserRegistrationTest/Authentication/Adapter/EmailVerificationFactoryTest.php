<?php

namespace HtUserRegistrationTest\Factory;

use Zend\ServiceManager\ServiceManager;
use HtUserRegistration\Mapper\UserRegistrationMapper;
use ZfcUser\Mapper\User;
use HtUserRegistration\Authentication\Adapter\EmailVerificationFactory;

class EmailVerificationFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $serviceManager->setService('HtUserRegistration\UserRegistrationMapper', new UserRegistrationMapper);
        $serviceManager->setService('zfcuser_user_mapper', new User);

        $factory = new EmailVerificationFactory;
        $this->assertInstanceOf('HtUserRegistration\Authentication\Adapter\EmailVerification', $factory->createService($serviceManager));
    }

}
