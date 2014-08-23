<?php
namespace HtUserRegistration\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use HtUserRegistration\Service\UserRegistrationService;

class UserRegistrationServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new UserRegistrationService(
            $serviceLocator,
            $serviceLocator->get('HtUserRegistration\UserRegistrationMapper'),
            $serviceLocator->get('HtUserRegistration\ModuleOptions'),
            $serviceLocator->get('zfcuser_user_mapper'),
            $serviceLocator->get('zfcuser_module_options')
        );
    }
}
