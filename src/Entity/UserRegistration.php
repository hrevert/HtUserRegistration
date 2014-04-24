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
    protected $token;
    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var DateTime
     */
    protected $requestTime;

    /**
     * @var bool
     */
    protected $responded = false;

    /**
     * Constructor
     * Intiliazes the entity
     *
     * @param UserInterface|null $user
     */
    public function __construct(UserInterface $user = null)
    {
        $this->requestTime = new DateTime;
        if ($user) {
            $this->setUser($user);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * {@inheritDoc}
     */
    public function generateToken()
    {
        $this->setToken(Rand::getString(static::REQUEST_KEY_LENGTH, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789', true));
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
        return $this->requestTime;
    }

    /**
     * {@inheritDoc}
     */
    public function setResponded($responded)
    {
        $this->responded = (bool) $responded;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getResponded()
    {
        return $this->responded;
    }

    /**
     * {@inheritDoc}
     */
    public function isResponded()
    {
        return $this->responded;
    }
}
