<?php
namespace HtUserRegistrationTest\Entity;

use HtUserRegistration\Entity\UserRegistration;
use ZfcUser\Entity\User;

class UserRegistrationTest extends \PHPUnit_Framework_TestCase
{
    public function testSettersAndGetters()
    {
        $user = new User;
        $entity = new UserRegistration($user);
        $entity->setToken('qweqweqwe');
        $requestTime = new \DateTime('24 hours ago');
        $entity->setRequestTime($requestTime);
        $entity->setResponded(true);
        $this->assertEquals($user, $entity->getUser());
        $this->assertEquals('qweqweqwe', $entity->getToken());
        $this->assertEquals($requestTime, $entity->getRequestTime());
        $this->assertEquals(true, $entity->getResponded());
    }
}
