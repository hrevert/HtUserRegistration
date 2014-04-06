<?php

namespace HtUserRegistrationTest\Stdlib\Hydrator;

use HtUserRegistration\Stdlib\Hydrator\UserRegistrationHydrator;
use HtUserRegistration\Entity\UserRegistration;
use ZfcUser\Entity\User;

class UserRegistrationHydratorTest extends \PHPUnit_Framework_TestCase
{
    public function testExtract()
    {
        $user = new User;
        $user->setId(13);
        $entity = new UserRegistration($user);
        $entity->setToken('fund');
        $requestTime = new \DateTime('2013-09-13 08:08:08');
        $entity->setRequestTime($requestTime);
        $entity->setResponded(true);
        $data = (new UserRegistrationHydrator)->extract($entity);
        $this->assertEquals(13, $data['user_id']);
        $this->assertEquals(true, $data['responded']);
        $this->assertEquals('fund', $data['token']);
        $this->assertEquals($requestTime->getTimestamp(), (new \DateTime($data['request_time']))->getTimestamp());
    }

    public function testHydrate()
    {
        $entity = new UserRegistration;
        (new UserRegistrationHydrator)->hydrate([
            'request_time' => '2013-09-13 08:08:08',
            'token' => 'fat',
            'responded' => 1
        ], $entity);
        $this->assertEquals((new \DateTime('2013-09-13 08:08:08'))->getTimestamp(), $entity->getRequestTime()->getTimestamp());
        $this->assertEquals(true, $entity->isResponded());
        $this->assertEquals('fat', $entity->getToken());
    }
}
