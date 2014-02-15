<?php

namespace HtUserRegistration\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use HtUserRegistration\Mapper\UserRegistrationMapper;

class UserRegistrationMapperFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $options = $serviceLocator->get('HtUserRegistration\ModuleOptions');
        $mapper = new UserRegistrationMapper();
        $mapper->setTableName($options->getRegistrationTableName());
        $entityPrototypeClass = $options->getRegistrationEntityClass();
        $mapper->setEntityPrototype(new $entityPrototypeClass);
        $mapper->setHydrator($serviceLocator->get('HtUserRegistration\UserRegistrationHydrator'));
        $mapper->setDbAdapter($serviceLocator->get('HtUserRegistration\DbAdapter'));

        return $mapper;
    }
}
