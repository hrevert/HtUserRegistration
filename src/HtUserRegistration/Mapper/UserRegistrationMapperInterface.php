<?php
namespace HtUserRegistration\Mapper;

use ZfcUser\Entity\UserInterface;
use HtUserRegistration\Entity\UserRegistration;
use Zend\Stdlib\Hydrator\HydratorInterface;

interface UserRegistrationMapperInterface
{
    /**
     * finds data of a user
     * @param UserInterface $user
     * @return UserRegistration | null
     *
     */
    public function findByUser(UserInterface $user);

    /**
     * Inserts a new row
     * 
     * @param UserRegistration $entity
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    public function insert($entity, $tableName = null, HydratorInterface $hydrator = null);

}
