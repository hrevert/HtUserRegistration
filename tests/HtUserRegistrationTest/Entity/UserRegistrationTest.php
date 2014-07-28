<?php
namespace HtUserRegistrationTest\Entity;

use HtUserRegistration\Entity\UserRegistration;
use ZfcUser\Entity\User;

class UserRegistrationTest extends \PHPUnit_Framework_TestCase
{
    public function testSettersAndGetters()
    {
        $user = new User;
        $userRegistration = new UserRegistration($user);
        $userRegistration->setToken('qweqweqwe');
        $requestTime = new \DateTime('24 hours ago');
        $userRegistration->setRequestTime($requestTime);
        $userRegistration->setResponded(true);
        $this->assertEquals($user, $userRegistration->getUser());
        $this->assertEquals('qweqweqwe', $userRegistration->getToken());
        $this->assertEquals($requestTime, $userRegistration->getRequestTime());
        $this->assertEquals(true, $userRegistration->getResponded());
        $this->assertTrue($userRegistration->isResponded());
        $userRegistration->setResponded(false);
        $this->assertFalse($userRegistration->isResponded());
    }

    public function testGenerateToken()
    {
        $userRegistration = new UserRegistration;
        $userRegistration->setToken('qweqweqwe');
        $userRegistration->generateToken();
        $this->assertNotEquals('qweqweqwe', $userRegistration->getToken());
    }
}
