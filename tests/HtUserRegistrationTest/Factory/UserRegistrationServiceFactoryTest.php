<?php
namespace HtUserRegistrationTest\Factory;

use Zend\ServiceManager\ServiceManager;
use HtUserRegistration\Factory\UserRegistrationServiceFactory;

class UserRegistrationServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;

        $userRegistrationMapper = $this->getMock('HtUserRegistration\Mapper\UserRegistrationMapperInterface');
        $serviceManager->setService('HtUserRegistration\UserRegistrationMapper', $userRegistrationMapper);

        $moduleOptions = $this->getMock('HtUserRegistration\Options\ModuleOptions');
        $serviceManager->setService('HtUserRegistration\ModuleOptions', $moduleOptions);
        
        $mailer = $this->getMock('HtUserRegistration\Mailer\MailerInterface');
        $serviceManager->setService('HtUserRegistration\Mailer\Mailer', $mailer);

        $userMapper = $this->getMock('ZfcUser\Mapper\UserInterface');
        $serviceManager->setService('zfcuser_user_mapper', $userMapper);

        $zfcUserOptions = $this->getMock('ZfcUser\Options\ModuleOptions');
        $serviceManager->setService('zfcuser_module_options', $zfcUserOptions);

        $factory = new UserRegistrationServiceFactory;
        $this->assertInstanceOf('HtUserRegistration\Service\UserRegistrationServiceInterface', $factory->createService($serviceManager));
    }    
}
