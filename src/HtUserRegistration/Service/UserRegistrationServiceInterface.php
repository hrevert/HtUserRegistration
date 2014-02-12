<?php
namespace HtUserRegistration\Service;

use Zend\EventManager\EventInterface;
use ZfcUser\Entity\UserInterface;

interface UserRegistrationServiceInterface
{
    public function onUserRegistration(EventInterface $e);

    public function sendVerificationEmail(UserInterface $user);

    public function sendPasswordRequestEmail(UserInterface $user);
}
