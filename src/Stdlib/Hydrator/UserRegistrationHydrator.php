<?php
namespace HtUserRegistration\Stdlib\Hydrator;

use Zend\Stdlib\Hydrator\ClassMethods;
use HtUserRegistration\Entity\UserRegistration;

class UserRegistrationHydrator extends ClassMethods
{
    public function extract($object)
    {
        $this->validateEntity($object, __METHOD__);
        $data = parent::extract($object);
        if ($data['request_time'] instanceof \DateTime) {
            $data['request_time'] = $data['request_time']->format('Y-m-d H:i:s');
        }

        $data['user_id'] = $object->getUser()->getId();
        unset($data['user']);
        unset($data['generate_request_key']);
        unset($data['is_responded']);

        return $data;
    }

    public function hydrate(array $data, $object)
    {
        $this->validateEntity($object, __METHOD__);

        if (!$data['request_time'] instanceof \DateTime) {
            $data['request_time'] = new \DateTime($data['request_time']);
        }

        return parent::hydrate($data, $object);
    }

    protected function validateEntity($object, $method)
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
