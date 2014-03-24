<?php
namespace HtUserRegistration\Service;

use Zend\EventManager\EventInterface;
use ZfcUser\Entity\UserInterface;
use HtUserRegistration\Entity\UserRegistrationInterface;

interface UserRegistrationServiceInterface
{
    /**
     * Listener for registration, when a new user is registered
     *
     * @param  EventInterface $e
     * @return void
     */
    public function onUserRegistration(EventInterface $e);

    /**
     * Sends verification email
     *
     * @var UserInterface $user
     *
     * @return void
     */
    public function sendVerificationEmail(UserInterface $user);

    /**
     * Sends password request email
     *
     * @var UserInterface $user
     *
     * @return void
     */
    public function sendPasswordRequestEmail(UserInterface $user);

    /**
     * Sets user`s email as verified
     *
     * @param  UserInterface $user
     * @param  string        $token
     * @return boolean
     */
    public function verifyEmail(UserInterface $user, $token);

    /**
     * Checks if registration token is valid
     *
     * @param UserInterface             $user
     * @param string                    $token
     * @param UserRegistrationInterface $record
     */
    public function isTokenValid(UserInterface $user, $token, UserRegistrationInterface $record);

    /**
     * Checks if token is expired
     *
     * @param  UserRegistrationInterface $record
     * @return bool
     */
    public function isTokenExpired(UserRegistrationInterface $record);

    /**
     * Sets a new password of a user
     *
     * @param  UserRegistrationInterface $record
     * @return void
     */
    public function setPassword(array $data, UserRegistrationInterface $registrationRecord);
}
