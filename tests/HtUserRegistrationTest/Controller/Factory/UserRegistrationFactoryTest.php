<?php

namespace HtUserRegistrationTest\Controller\Factory;

use Zend\ServiceManager\ServiceManager;
use HtUserRegistration\Controller\Factory\UserRegistrationFactory;

class UserRegistrationFactoryTest extends \PHPUnit_Framework_TestCase
{

    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $serviceManager->setService('HtUserRegistration\UserRegistrationService', $this->getMockBuilder('HtUserRegistration\Service\UserRegistrationService')
                        ->disableOriginalConstructor()
                        ->getMock()
        );

        $controller = $this->getMock('Zend\Mvc\Controller\ControllerManager');
        $controller->expects($this->once())
                ->method('getServiceLocator')
                ->will($this->returnValue($serviceManager));

        $factory = new UserRegistrationFactory;
        $this->assertInstanceOf('HtUserRegistration\Controller\UserRegistrationController', $factory->createService($controller));
    }

}
