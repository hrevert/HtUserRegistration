<?php
namespace HtUserRegistrationTest\Service;

use HtUserRegistration\Service\UserRegistrationService;
use Zend\ServiceManager\ServiceManager;
use HtUserRegistration\Options\ModuleOptions;
use HtUserRegistration\Entity\UserRegistration;
use ZfcUser\Entity\User;

class UserRegistrationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testIsTokenExpired()
    {
        $service = new UserRegistrationService();        
        $serviceManager = new ServiceManager;
        $service->setServiceLocator($serviceManager);
        $options = new ModuleOptions([
            'request_expiry' => 86400, // 1 day
        ]);
        $serviceManager->setService('HtUserRegistration\ModuleOptions', $options);
        $entity = new UserRegistration;
        $entity->setRequestTime(new \DateTime('25 hours ago'));
        $this->assertEquals(true, $service->isTokenExpired($entity));
        $entity->setRequestTime(new \DateTime('23 hours ago'));
        $this->assertEquals(false, $service->isTokenExpired($entity));
    }
     
}
