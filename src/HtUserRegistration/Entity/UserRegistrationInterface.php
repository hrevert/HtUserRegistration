<?php
namespace HtUserRegistration\Entity;

use DateTime;
use ZfcUser\Entity\UserInterface;

interface UserRegistrationInterface
{
    /**
     * Sets requestKey
     *
     * @param string $requestKey
     * @return self
     */ 
    public function setRequestKey($requestKey);

    /**
     * Gets requestKey
     *
     * @return string
     */
    public function getRequestKey();

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
