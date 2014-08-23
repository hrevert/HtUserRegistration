<?php
namespace HtUserRegistrationTest\Service;

use HtUserRegistration\Service\UserRegistrationService;
use HtUserRegistration\Options\ModuleOptions;
use HtUserRegistration\Entity\UserRegistration;

class UserRegistrationServiceTest extends \PHPUnit_Framework_TestCase
{
    public function testIsTokenExpired()
    {
        $userRegistrationMapper = $this->getMock('HtUserRegistration\Mapper\UserRegistrationMapperInterface');
        $options = new ModuleOptions([
            'request_expiry' => 86400, // 1 day
        ]);
        $mailer = $this->getMock('HtUserRegistration\Mailer\MailerInterface');
        $userMapper = $this->getMock('ZfcUser\Mapper\UserInterface');
        $zfcUserOptions = $this->getMock('ZfcUser\Options\ModuleOptions');

        $service = new UserRegistrationService($userRegistrationMapper, $options, $mailer, $userMapper, $zfcUserOptions);        

        $entity = new UserRegistration;
        $entity->setRequestTime(new \DateTime('25 hours ago'));
        $this->assertEquals(true, $service->isTokenExpired($entity));
        $entity->setRequestTime(new \DateTime('23 hours ago'));
        $this->assertEquals(false, $service->isTokenExpired($entity));
    }
     
}
