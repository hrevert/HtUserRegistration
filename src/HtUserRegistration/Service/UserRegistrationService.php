<?php
namespace HtUserRegistration\Service;

use HtUserRegistration\Mapper\UserRegistrationMapperInterface;
use Zend\EventManager\EventInterface;
use ZfcUser\Entity\UserInterface;
use ZfcBase\EventManager\EventProvider;

class UserRegistrationService extends EventProvider
{   
    /**
     * @var UserRegistrationMapperInterface
     */
    protected $userRegistrationMapper;

    protected $moduleOptions;

    protected $zfcUserOptions;

    use \Zend\ServiceManager\ServiceLocatorAwareTrait;

    public onUserRegistration(EventInterface $e)
    {
        $user = $e->getParam('user');
        if ($this->getOptions()->getSendVerificationEmail() && $this->getZfcUserOptions()->getEnableRegistration()) {
            $this->sendVerificationEmail($user);
        } elseif ($this->getOptions()->getSendPasswordRequestEmail() && !$this->getZfcUserOptions()->getEnableRegistration()) {
            $this->sendPasswordRequestEmail($user);
        }

        // do nothing
    }

    public function sendVerificationEmail(UserInterface $user)
    {
        
    }

    public function sendPasswordRequestEmail(UserInterface $user)
    {
        
    }

    /**
     * Gets userRegistrationMapper
     */
    protected function getUserRegistrationMapper()
    {
        if (!$this->userRegistrationMapper instanceof UserRegistrationMapperInterface) {
            $this->userRegistrationMapper = $this->getServiceLocator()->get('HtUserRegistration\UserRegistrationMapper');
        }

        return $this->userRegistrationMapper;
    }

    /**
     * Gets moduleOptions
     */
    protected function getOptions()
    {
        if (!$this->moduleOptions) {
            $this->moduleOptions = $this->getServiceLocator()->get('HtUserRegistration\ModuleOptions');
        }

        return $this->moduleOptions;
    }

    /**
     * Gets zfcUserOptions
     */
    public function getZfcUserOptions()
    {
        if (!$this->zfcUserOptions) {
            $this->zfcUserOptions = $this->getServiceLocator()->get('zfcuser_module_options');
        }

        return $this->zfcUserOptions;
    }
}
