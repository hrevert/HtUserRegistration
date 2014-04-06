<?php
namespace HtUserRegistration\Mapper;

use ZfcUser\Entity\UserInterface;
use HtUserRegistration\Entity\UserRegistration;
use Zend\Stdlib\Hydrator\HydratorInterface;

interface UserRegistrationMapperInterface
{

    /**
     * finds data of a user
     * @param  UserInterface    $user
     * @return UserRegistration | null
     *
     */
    public function findByUser(UserInterface $user);

    /**
     * Inserts a new row
     *
     * @param  UserRegistration                             $entity
     * @return \Zend\Db\Adapter\Driver\ResultInterface|null
     */
    public function insert($entity);

    /**
     * Updates registration data related to a user
     *
     * @param  UserRegistration                             $entity
     * @param string|array|closure $where
     * @return \Zend\Db\Adapter\Driver\ResultInterface|null
     */
    public function update($entity, $where = null);
}
