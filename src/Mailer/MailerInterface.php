<?php
namespace HtUserRegistration\Mailer;

use HtUserRegistration\Entity\UserRegistrationInterface;

interface MailerInterface
{
    /**
     * Sends verification email
     *
     * @param UserRegistrationInterface $userRegistration
     */
    public function sendVerificationEmail(UserRegistrationInterface $userRegistration);

    /**
     * Sends password request email
     *
     * @param UserRegistrationInterface $userRegistration
     */
    public function sendPasswordRequestEmail(UserRegistrationInterface $userRegistration);
}
