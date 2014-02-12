<?php
namespace HtUserRegistration\Entity;

use DateTime;
use ZfcUser\Entity\UserInterface;

interface UserRegistrationInterface
{
    const EMAIL_NOT_RESPONDED = 0;

    const EMAIL_RESPONDED = 1;

    /**
     * Sets token
     *
     * @param string $token
     * @return self
     */ 
    public function setToken($token);

    /**
     * Gets token
     *
     * @return string
     */
    public function getToken();

    /**
     * Generates a random requestKey
     *
     * @return void
     */
    public function generateRequestKey();

    /**
     * Sets user
     *
     * @param UserInterface $user
     * @return self
     */
    public function setUser(UserInterface $user);

    /**
     * Gets user
     *
     * @return int
     */
    public function getUser();

    /**
     * Sets requestTime
     *
     * @param DateTime $requestTime
     * @return self
     */
    public function setRequestTime(DateTime $requestTime);

    /**
     * Gets requestTime
     *
     * @return DateTime
     */
    public function getRequestTime();
}
