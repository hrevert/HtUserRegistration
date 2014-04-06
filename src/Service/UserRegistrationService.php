<?php
namespace HtUserRegistration\Service;

use HtUserRegistration\Mapper\UserRegistrationMapperInterface;
use Zend\EventManager\EventInterface;
use ZfcUser\Entity\UserInterface;
use ZfcBase\EventManager\EventProvider;
use DateTime;
use HtUserRegistration\Entity\UserRegistrationInterface;
use HtUserRegistration\Entity\UserRegistration;
use Zend\Crypt\Password\Bcrypt;

class UserRegistrationService extends EventProvider implements UserRegistrationServiceInterface
{
    /**
     * @var UserRegistrationMapperInterface
     */
    protected $userRegistrationMapper;

    /**
     * @var \HtUserRegistration\Options\ModuleOptions
     */
    protected $moduleOptions;

    /**
     * @var \ZfcUser\Options\ModuleOptions
     */
    protected $zfcUserOptions;

    /**
     * @var \ZfcUser\Mapper\UserInterface
     */
    protected $userMapper;

    use \Zend\ServiceManager\ServiceLocatorAwareTrait;

    /**
     * {@inheritDoc}
     */
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

    /**
     * {@inheritDoc}
     */
    public function sendVerificationEmail(UserInterface $user)
    {
        // suppose email is sent
        $registrationRecord = $this->createRegistrationRecord($user);

        $mailService = $this->getServiceLocator()->get('goaliomailservice_message');

        $message = $mailService->createHtmlMessage(
            $this->getOptions()->getEmailFromAddress(),
            $user->getEmail(),
            $this->getOptions()->getVerificationEmailSubject(),
            $this->getOptions()->getVerificationEmailTemplate(),
            array('user' => $user, 'registrationRecord' => $registrationRecord)
        );

        $mailService->send($message);

    }

    /**
     * {@inheritDoc}
     */
    public function sendPasswordRequestEmail(UserInterface $user)
    {
        // suppose email is sent
        $registrationRecord = $this->createRegistrationRecord($user);

        $mailService = $this->getServiceLocator()->get('goaliomailservice_message');

        $message = $mailService->createHtmlMessage(
            $this->getOptions()->getEmailFromAddress(),
            $user->getEmail(),
            $this->getOptions()->getPasswordRequestEmailSubject(),
            $this->getOptions()->getPasswordRequestEmailTemplate(),
            array('user' => $user, 'registrationRecord' => $registrationRecord)
        );

        $mailService->send($message);
    }

    /**
     * Stored user registration record to database
     *
     * @return UserInterface             $user
     * @return UserRegistrationInterface
     */
    protected function createRegistrationRecord(UserInterface $user)
    {
        $entityClass = $this->getOptions()->getRegistrationEntityClass();
        $entity = new $entityClass($user);
        $this->getEventManager()->trigger(__METHOD__, $this, array('user' => $user, 'record' => $entity));
        $entity->generateRequestKey();
        $this->getUserRegistrationMapper()->insert($entity);
        $this->getEventManager()->trigger(__METHOD__ . '.post', $this, array('user' => $user, 'record' => $entity));

        return $entity;
    }

    /**
     * {@inheritDoc}
     */
    public function verifyEmail(UserInterface $user, $token)
    {
        $record = $this->getUserRegistrationMapper()->findByUser($user);
        $this->getEventManager()->trigger(__METHOD__, $this, array('user' => $user, 'token' => $token, 'record' => $record));

        if (!$record || !$this->isTokenValid($user, $token, $record)) {
            return false;
        }
        if (!$record->isResponded()) {
            $record->setResponded(UserRegistrationInterface::EMAIL_RESPONDED);
            $this->getUserRegistrationMapper()->update($record);
        }

        $this->getEventManager()->trigger(__METHOD__ . '.post', $this, array('user' => $user, 'token' => $token, 'record' => $record));

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isTokenValid(UserInterface $user, $token, UserRegistrationInterface $record)
    {
        if ($record->getToken() !== $token) {
            $this->getEventManager()->trigger('tokenInvalid', $this, array('user' => $user, 'token' => $token, 'record' => $record));

            return false;
        } elseif ($this->getOptions()->getEnableRequestExpiry() && $this->isTokenExpired($record)) {
            $this->getEventManager()->trigger('tokenExpired', $this, array('user' => $user, 'token' => $token, 'record' => $record));

            return false;
        }
        $this->getEventManager()->trigger('tokenValid', $this, array('user' => $user, 'token' => $token, 'record' => $record));

        return true;
    }

    /**
     * {@inheritDoc}
     */
    public function isTokenExpired(UserRegistrationInterface $record)
    {
        $expiryDate = new DateTime($this->getOptions()->getRequestExpiry() . ' seconds ago');

        return $record->getRequestTime() < $expiryDate;
    }

    /**
     * {@inheritDoc}
     */
    public function setPassword(array $data, UserRegistrationInterface $registrationRecord)
    {
        $newPass = $data['newCredential'];
        $user = $registrationRecord->getUser();

        $bcrypt = new Bcrypt;
        $bcrypt->setCost($this->getZfcUserOptions()->getPasswordCost());

        $pass = $bcrypt->create($newPass);
        $user->setPassword($pass);

        $this->getEventManager()->trigger(__FUNCTION__, $this, array('user' => $user, 'record' => $registrationRecord));
        $this->getUserMapper()->update($user);
        $registrationRecord->setResponded(UserRegistrationInterface::EMAIL_RESPONDED);
        $this->getUserRegistrationMapper()->update($registrationRecord);
        $this->getEventManager()->trigger(__FUNCTION__ . '.post', $this, array('user' => $user, 'record' => $registrationRecord));
    }

    /**
     * Gets userRegistrationMapper
     *
     * @return UserRegistrationMapperInterface
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

    /**
     * Gets userMapper
     */
    public function getUserMapper()
    {
        if (!$this->userMapper) {
            $this->userMapper = $this->getServiceLocator()->get('zfcuser_user_mapper');
        }

        return $this->userMapper;
    }
}
