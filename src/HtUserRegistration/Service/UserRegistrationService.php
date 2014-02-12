<?php
namespace HtUserRegistration\Service;

use HtUserRegistration\Mapper\UserRegistrationMapperInterface;
use Zend\EventManager\EventInterface;
use ZfcUser\Entity\UserInterface;
use ZfcBase\EventManager\EventProvider;
use DateTime;
use HtUserRegistration\Entity\UserRegistrationInterface;
use HtUserRegistration\Entity\UserRegistration;

class UserRegistrationService extends EventProvider implements UserRegistrationServiceInterface
{   
    /**
     * @var UserRegistrationMapperInterface
     */
    protected $userRegistrationMapper;

    protected $moduleOptions;

    protected $zfcUserOptions;

    use \Zend\ServiceManager\ServiceLocatorAwareTrait;

    public function onUserRegistration(EventInterface $e)
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
        // suppose email is sent
        $this->createRegistrationRecord($user);
    }

    public function sendPasswordRequestEmail(UserInterface $user)
    {
        // suppose email is sent
        $this->createRegistrationRecord($user);        
    }

    protected function createRegistrationRecord($user)
    {
        $entity = new UserRegistration;
        $this->getEventManager()->trigger(__METHOD__, $this, array('user' => $user, 'record' => $entity));
        $entity->setUser($user);
        $entity->generateRequestKey();
        $this->getUserRegistrationMapper()->insert($entity);
        $this->getEventManager()->trigger(__METHOD__ . '.post', $this, array('user' => $user, 'record' => $entity));
    }

    public function verifyEmail(UserInterface $user, $token)
    {
        $record = $this->getUserRegistrationMapper()->findByUser($user);
        $this->getEventManager()->trigger(__METHOD__, $this, array('user' => $user, 'token' => $token, 'record' => $record));
        
        if (!$this->isTokenValid($user, $token, $record)) {
            return false;
        }
        if (!$record->isResponded()) {
            $record->setResponded(UserRegistrationInterface::EMAIL_RESPONDED);
            $this->getUserRegistrationMapper()->update($record);
        }
        
        $this->getEventManager()->trigger(__METHOD__ . '.post', $this, array('user' => $user, 'token' => $token, 'record' => $record));

        return true;
    }


    public function isTokenValid(UserInterface $user, $token, $record)
    {
        if (
            !$record
            || $record->getToken() !== $token 
            || ($this->getOptions()->getEnableRequestExpiry() && $this->isTokenExpired($record))
        ) {
            $this->getEventManager()->trigger('tokenInvalid', $this, array('user' => $user, 'token' => $token, 'record' => $record));
            return false;
        }
        $this->getEventManager()->trigger('tokenValid', $this, array('user' => $user, 'token' => $token, 'record' => $record));

        return true;
    }

    public function isTokenExpired(UserRegistrationInterface $record)
    {
        $expiryDate = new DateTime($this->getOptions()->getRequestExpiry() . 'seconds ago');
        return $record->getRequestTime() < $expiryDate;
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
