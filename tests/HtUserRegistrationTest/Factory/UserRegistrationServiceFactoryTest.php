<?php
namespace HtUserRegistrationTest\Factory;

use Zend\ServiceManager\ServiceManager;
use HtUserRegistration\Factory\UserRegistrationServiceFactory;

class UserRegistrationServiceFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $factory = new UserRegistrationServiceFactory;
        $this->assertInstanceOf('HtUserRegistration\Service\UserRegistrationServiceInterface', $factory->createService($serviceManager));
    }    
}
