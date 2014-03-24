<?php

namespace HtUserRegistration\Entity;

use DateTime;
use Zend\Math\Rand;
use ZfcUser\Entity\UserInterface;
use HtUserRegistration\Exception;

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
     * @var int
     */
    protected $responded = self::EMAIL_NOT_RESPONDED;

    /**
     * Intiliazes the entity
     */
    public function __construct()
    {
        $this->requestTime = new DateTime;
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
    public function generateRequestKey()
    {
        $this->setToken(Rand::getString(static::REQUEST_KEY_LENGTH, null, true));
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
        if ($responded != static::EMAIL_NOT_RESPONDED && $responded != static::EMAIL_RESPONDED) {
            throw new Exception\InvalidArgumentException(
                sprintf(
                    '%s expects parameter 1 to be one of %s or %s, %s provided instead',
                    __METHOD__,
                    static::EMAIL_NOT_RESPONDED,
                    static::EMAIL_RESPONDED,
                    is_object($responded) ? get_class($responded) : gettype($responded)
                )
            );
        }

        $this->responded = (int) $responded;

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
        return $this->responded === static::EMAIL_RESPONDED;
    }
}
