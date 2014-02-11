<?php
namespace HtUserRegistration\Listener;

use Zend\EventManager\SharedListenerAggregateInterface;
use Zend\EventManager\SharedEventManagerInterface;
use HtUserRegistration\Service\UserRegistrationService;
use Zend\EventManager\EventInterface;

class RegistrationListener implements SharedListenerAggregateInterface
{
    protected $userRegistrationService;

    protected $zfcUserOptions;

    public function __construct(UserRegistrationService $userRegistrationService)
    {
        $this->userRegistrationService = $userRegistrationService;
    }

    public function attachShared(SharedEventManagerInterface $sharedManager, $priority = 1)
    {
        $sharedManager->attach('User\Service\User', 'register.post', array($this, 'sendEmail'), $priority);
    }

}
