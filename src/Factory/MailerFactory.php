<?php
namespace HtUserRegistration\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use HtUserRegistration\Mailer\Mailer;

class MailerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        return new Mailer(
            $serviceLocator->get('HtUserRegistration\ModuleOptions'), 
            $serviceLocator->get('MtMail\Service\Mail')
        );
    }    
}
