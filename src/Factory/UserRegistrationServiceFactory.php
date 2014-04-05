<?php
namespace HtUserRegistration\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use HtUserRegistration\Service\UserRegistrationService;

class UserRegistrationServiceFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $service = new UserRegistrationService;
        $service->setServiceLocator($serviceLocator);

        return $service;
    }
}
