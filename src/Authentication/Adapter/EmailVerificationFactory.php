<?php
namespace HtUserRegistration\Authentication\Adapter;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class EmailVerificationFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new EmailVerification(
            $serviceLocator->get('HtUserRegistration\UserRegistrationMapper'),
            $serviceLocator->get('zfcuser_user_mapper')
        );
    }
}
