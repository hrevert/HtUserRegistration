<?php
namespace HtUserRegistration;

use Zend\Mvc\MvcEvent;
use Zend\EventManager\EventInterface;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $application    = $e->getApplication();
        $eventManager   = $application->getEventManager();
        $sharedManager  = $eventManager->getSharedManager();
        $sharedManager->attach('ZfcUser\Service\User', 'register.post', function (EventInterface $event) use ($application) {
            $serviceLocator = $application->getServiceManager();
            $userRegistrationService = $serviceLocator->get('HtUserRegistration\UserRegistrationService');
            $userRegistrationService->onUserRegistration($event);
        });
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'HtUserRegistration\ModuleOptions' => 'HtUserRegistration\Factory\ModuleOptionsFactory',
                'HtUserRegistration\UserRegistrationMapper' => 'HtUserRegistration\Factory\UserRegistrationMapperFactory',
                'HtUserRegistration\UserRegistrationService' => 'HtUserRegistration\Factory\UserRegistrationServiceFactory',
                'HtUserRegistration\SetPasswordForm' => 'HtUserRegistration\Factory\SetPasswordFormFactory',
                'HtUserRegistration\Authentication\Adapter\EmailVerification' => 'HtUserRegistration\Authentication\Adapter\EmailVerificationFactory',
            ),
            'aliases' => array(
                'HtUserRegistration\DbAdapter' => 'Zend\Db\Adapter\Adapter'
            ),
            'invokables' => array(
                'HtUserRegistration\UserRegistrationHydrator' => 'HtUserRegistration\Stdlib\Hydrator\UserRegistrationHydrator'
            )
        );
    }
}
