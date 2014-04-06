<?php
namespace HtUserRegistrationTest\Factory;

use Zend\ServiceManager\ServiceManager;
use HtUserRegistration\Factory\UserRegistrationMapperFactory;
use HtUserRegistration\Options\ModuleOptions;
use Zend\Stdlib\Hydrator\ClassMethods;

class UserRegistrationMapperFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $serviceManager->setService('HtUserRegistration\ModuleOptions', new ModuleOptions);
        $serviceManager->setService('HtUserRegistration\UserRegistrationHydrator', new ClassMethods);
        $adapter = $this->getMockBuilder('Zend\Db\Adapter\Adapter')
            ->disableOriginalConstructor()
            ->getMock();
        $serviceManager->setService('HtUserRegistration\DbAdapter', $adapter);
        $factory = new UserRegistrationMapperFactory;
        $this->assertInstanceOf('HtUserRegistration\Mapper\UserRegistrationMapper', $factory->createService($serviceManager));
    }    
}
