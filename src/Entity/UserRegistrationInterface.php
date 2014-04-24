<?php
namespace HtUserRegistration\Entity;

use DateTime;
use ZfcUser\Entity\UserInterface;

interface UserRegistrationInterface
{
    const EMAIL_NOT_RESPONDED = false;

    const EMAIL_RESPONDED = true;

    /**
     * Sets token
     *
     * @param  string $token
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
    public function generateToken();

    /**
     * Sets user
     *
     * @param  UserInterface $user
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
     * @param  DateTime $requestTime
     * @return self
     */
    public function setRequestTime(DateTime $requestTime);

    /**
     * Gets requestTime
     *
     * @return DateTime
     */
    public function getRequestTime();

    /**
     * Sets if email is responded or not
     *
     * @param bool $responded
     */
    public function setResponded($responded);

    /**
     * Gets if email is responded or not
     *
     * @return bool
     */
    public function getResponded();

    /**
     * Checks if email is responded
     *
     * @return bool
     */
    public function isResponded();
}
