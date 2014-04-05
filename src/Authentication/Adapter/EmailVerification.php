<?php
namespace HtUserRegistration\Authentication\Adapter;

use ZfcUser\Authentication\Adapter\AbstractAdapter;
use Zend\Authentication\Result as AuthenticationResult;
use ZfcUser\Authentication\Adapter\AdapterChainEvent;
use HtUserRegistration\Mapper\UserRegistrationMapperInterface;
use ZfcUser\Mapper\UserInterface as UserMapper;

class EmailVerification extends AbstractAdapter
{
    /**
     * @var UserRegistrationMapperInterface
     */
    protected $userRegistrationMapper;

    /**
     * @var UserMapper
     */
    protected $userMapper;

    /**
     * Constructor
     *
     * @param UserRegistrationMapperInterface $userRegistrationMapper
     * @param UserMapper                      $userMapper
     */
    public function __construct(UserRegistrationMapperInterface $userRegistrationMapper, UserMapper $userMapper)
    {
        $this->userRegistrationMapper = $userRegistrationMapper;
        $this->userMapper = $userMapper;
    }

    /**
     * @param  AdapterChainEvent $e
     * @return bool
     */
    public function authenticate(AdapterChainEvent $e)
    {
        if ($e->getIdentity()) {
            $userObject = $this->userMapper->findById($e->getIdentity());
            $registrationRecord = $this->userRegistrationMapper->findByUser($userObject);
            if (!$registrationRecord || !$registrationRecord->isResponded()) {
                $e->setCode(AuthenticationResult::FAILURE)
                ->setMessages(array('Email Address not verified yet'));

                return false;
            }

            return true;
        }

        return false;
    }
}
