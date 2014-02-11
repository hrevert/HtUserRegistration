<?php
namespace HtUserRegistration\Service;

use ZfcUser\Entity\UserInterface;

interface MailSenderInterface
{
    /**
     * Sends mail to the user with a link to set the password
     * 
     * @param UserInterface $user
     *
     * @return bool
     */
    public function sendMail(UserInterface $user);
}
