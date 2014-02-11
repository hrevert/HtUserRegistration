<?php
namespace HtUserRegistration\Service;

use HtUserRegistration\Mapper\UserRegistrationMapperInterface;

class UserRegistrationService
{   
    /**
     * @var UserRegistrationMapperInterface
     */
    protected $userRegistrationMapper;

    protected $moduleOptions;

    use \Zend\ServiceManager\ServiceLocatorAwareTrait;

    /**
     * Gets userRegistrationMapper
     */
    public function getUserRegistrationMapper()
    {
        if (!$this->userRegistrationMapper instanceof UserRegistrationMapperInterface) {
            $this->userRegistrationMapper = $this->getServiceLocator()->get('HtUserRegistration\UserRegistrationMapper');
        }
        $this->userRegistrationMapper = $userRegistrationMapper;
    }

    public function getOptions()
    {
        if (!$this->moduleOptions) {
            $this->moduleOptions = $this->getServiceLocator()->get('$this->moduleOptions');
        }

        return $this->moduleOptions;
    }
}
