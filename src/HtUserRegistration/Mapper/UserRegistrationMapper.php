<?php
namespace HtUserRegistration\Mapper;

use ZfcUser\Entity\UserInterface;
use ZfcBase\Mapper\AbstractDbMapper;
use HtUserRegistration\Entity\UserRegistration;

class UserRegistrationMapper extends AbstractDbMapper implements UserRegistrationMapperInterface
{
    /**
     * @var string
     */
    protected $tableName;

    /**
     * {@inheritDoc}
     */
    public function findByUser(UserInterface $user)
    {
        $select = $this->getSelect();
        $select->where('user_id' => $user->getId());
        $entity = $this->select($select)->current();
        if ($entity instanceof UserRegistration) {
            $entity->setUser($user);
        }

        return $entity;
    }

    /**
     * {@inheritDoc}
     */
    public function insert($entity, $tableName = null, HydratorInterface $hydrator = null)
    {
        return parent::insert($entity);
    }


    /**
     * Sets tableName
     *
     * @param string $tableName
     * @return self
     */
    public function setTableName($tableName)
    {
        $this->tableName = $tableName;

        return $this;
    }
}
