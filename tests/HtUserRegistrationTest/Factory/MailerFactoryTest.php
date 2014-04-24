<?php
namespace HtUserRegistrationTest\Factory;

use Zend\ServiceManager\ServiceManager;
use HtUserRegistration\Factory\MailerFactory;
use HtUserRegistration\Options\ModuleOptions;
use GoalioMailService\Mail\Service\Message;

class MailerFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $serviceManager = new ServiceManager;
        $serviceManager->setService('HtUserRegistration\ModuleOptions', new ModuleOptions);
        $serviceManager->setService('goaliomailservice_message', new Message);
        $factory = new MailerFactory;
        $this->assertInstanceOf('HtUserRegistration\Mailer\Mailer', $factory->createService($serviceManager));
    }    
}
