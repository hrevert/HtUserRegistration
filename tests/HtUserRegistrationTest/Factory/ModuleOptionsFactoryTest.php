<?php
namespace HtUserRegistrationTest\Factory;

use Zend\ServiceManager\ServiceManager;
use HtUserRegistration\Factory\ModuleOptionsFactory;

class ModuleOptionsFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $serviceManager->setService('Config', ['ht_user_registration' => []]);
        $factory = new ModuleOptionsFactory;
        $this->assertInstanceOf('HtUserRegistration\Options\ModuleOptions', $factory->createService($serviceManager));
    }
}
