<?php
namespace HtUserRegistration\Entity;

use DateTime;

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
     * Sets userId
     *
     * @param string $userId
     * @return int
     */
    public function setUserId($userId);

    /**
     * Gets userId
     *
     * @return int
     */
    public function getUserId();

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
