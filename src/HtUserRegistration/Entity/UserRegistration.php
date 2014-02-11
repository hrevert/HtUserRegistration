<?php

namespace HtUserRegistration\Entity;

use DateTime;
use Zend\Math\Rand;
use ZfcUser\Entity\UserInterface;

class UserRegistration implements UserRegistrationInterface
{
    // length of request key
    const REQUEST_KEY_LENGTH = 16;

    /**
     * @var string
     */
    protected $requestKey;

    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var DateTime
     */
    protected $requestTime;

    /**
     * {@inheritDoc}
     */
    public function setRequestKey($requestKey)
    {
        $this->requestKey = $requestKey;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRequestKey()
    {
        return $this->requestKey;
    }

    /**
     * {@inheritDoc}
     */
    public function generateRequestKey()
    {
        $this->setRequestKey(Rand::getString(static::REQUEST_KEY_LENGTH, null, true));
    }

    /**
     * {@inheritDoc}
     */
    public function setUser(UserInterface $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * {@inheritDoc}
     */
    public function setRequestTime(DateTime $requestTime)
    {
        $this->requestTime = $requestTime;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getRequestTime()
    {
        if (!$this->requestTime instanceof DateTime) {
            $this->requestTime = new DateTime('now');
        }

        return $this->requestTime;
    }

}
