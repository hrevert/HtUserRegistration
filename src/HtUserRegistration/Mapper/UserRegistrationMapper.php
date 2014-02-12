<?php
namespace HtUserRegistration\Mapper;

use ZfcUser\Entity\UserInterface;
use ZfcBase\Mapper\AbstractDbMapper;
use HtUserRegistration\Entity\UserRegistration;
use Zend\Stdlib\Hydrator\HydratorInterface;

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
        $this->checkEntity($entity, __METHOD__);

        return parent::insert($entity);
    }

    /**
     * {@inheritDoc}
     */
    public function update($entity, $where = null, $tableName = null, HydratorInterface $hydrator = null)
    {
        $this->checkEntity($entity, __METHOD__);
        if (!$where) {
            $where = array('user_id' => $entity->getUser()->getId());
        }
        
        return parent::update($entity, $where, $tableName, $hydrator);        
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

    protected function checkEntity($object, $method)
    {
        if (!$object instanceof UserRegistration) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s expects parameter 1 to be an instance of %s, %s provided instead',
                    $method,
                    'HtUserRegistration\Entity\UserRegistration',
                    is_object($object) ? get_class($object) : gettype($object)
                )
            );
        }        
    }
}
