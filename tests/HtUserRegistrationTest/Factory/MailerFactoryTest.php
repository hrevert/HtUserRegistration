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
        $mailService = $this->getMockBuilder('MtMail\Service\Mail')
            ->disableOriginalConstructor()
            ->getMock();
        $serviceManager->setService('MtMail\Service\Mail', $mailService);
        $factory = new MailerFactory;
        $this->assertInstanceOf('HtUserRegistration\Mailer\Mailer', $factory->createService($serviceManager));
    }    
}
