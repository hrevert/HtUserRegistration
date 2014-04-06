<?php
namespace HtUserRegistration\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions implements
    TemplateOptionsInterface,
    RequestExpiryOptionsInterface,
    EmailOptionsInterface,
    FeatureOptionsInterface,
    DatabaseOptionsInterface
{
    /**
     * @var string | array
     */
    protected $emailFromAddress = '';

    /**
     * @var string
     */
    protected $verificationEmailTemplate = 'ht-user-registration/mail/verify-email.phtml';

    /**
     * @var string
     */
    protected $passwordRequestEmailTemplate = 'ht-user-registration/mail/set-password.phtml';

    /**
     * @var boolean
     */
    protected $enableRequestExpiry = false;

    /**
     * @var int
     */
    protected $requestExpiry = 86400; // 1 day

    /**
     * @var string
     */
    protected $registrationTableName = 'user_registration';

    /**
     * @var string
     */
    protected $registrationEntityClass = 'HtUserRegistration\Entity\UserRegistration';

    /**
     * @var boolean
     */
    protected $sendVerificationEmail = true;

    /**
     * @var boolean
     */
    protected $sendPasswordRequestEmail = true;

    /**
     * @var string
     */
    protected $verificationEmailSubject = 'Email Address Verification';

    /**
     * @var string
     */
    protected $passwordRequestEmailSubject = 'Set Your Password';

    /**
     * @var string
     */
    protected $postVerificationRoute = 'zfcuser/login';

    public function setEmailFromAddress($emailFromAddress)
    {
        $this->emailFromAddress = $emailFromAddress;

        return $this;
    }

    public function getEmailFromAddress()
    {
        return $this->emailFromAddress;
    }

    public function setVerificationEmailTemplate($verificationEmailTemplate)
    {
        $this->verificationEmailTemplate = $verificationEmailTemplate;

        return $this;
    }

    public function getVerificationEmailTemplate()
    {
        return $this->verificationEmailTemplate;
    }

    public function setPasswordRequestEmailTemplate($passwordRequestEmailTemplate)
    {
        $this->passwordRequestEmailTemplate = $passwordRequestEmailTemplate;

        return $this;
    }

    public function getPasswordRequestEmailTemplate()
    {
        return $this->passwordRequestEmailTemplate;
    }

    public function setEnableRequestExpiry($enableRequestExpiry)
    {
        $this->enableRequestExpiry = (bool) $enableRequestExpiry;

        return $this;
    }

    public function getEnableRequestExpiry()
    {
        return $this->enableRequestExpiry;
    }

    public function setRequestExpiry($requestExpiry)
    {
        $this->requestExpiry = $requestExpiry;

        return $this;
    }

    public function getRequestExpiry()
    {
        return $this->requestExpiry;
    }

    public function setRegistrationTableName($registrationTableName)
    {
        $this->registrationTableName = $registrationTableName;

        return $this;
    }

    public function getRegistrationTableName()
    {
        return $this->registrationTableName;
    }

    public function setRegistrationEntityClass($registrationEntityClass)
    {
        $this->registrationEntityClass = $registrationEntityClass;

        return $this;
    }

    public function getRegistrationEntityClass()
    {
        return $this->registrationEntityClass;
    }

    public function setSendVerificationEmail($sendVerificationEmail)
    {
        $this->sendVerificationEmail = (bool) $sendVerificationEmail;

        return $this;
    }

    public function getSendVerificationEmail()
    {
        return $this->sendVerificationEmail;
    }

    public function setSendPasswordRequestEmail($sendPasswordRequestEmail)
    {
        $this->sendPasswordRequestEmail = (bool) $sendPasswordRequestEmail;

        return $this;
    }

    public function getSendPasswordRequestEmail()
    {
        return $this->sendPasswordRequestEmail;
    }

    public function setVerificationEmailSubject($verificationEmailSubject)
    {
        $this->verificationEmailSubject = $verificationEmailSubject;

        return $this;
    }

    public function getVerificationEmailSubject()
    {
        return $this->verificationEmailSubject;
    }

    public function setPasswordRequestEmailSubject($passwordRequestEmailSubject)
    {
        $this->passwordRequestEmailSubject = $passwordRequestEmailSubject;

        return $this;
    }

    public function getPasswordRequestEmailSubject()
    {
        return $this->passwordRequestEmailSubject;
    }

    /**
     * 
     */
    public function setPostVerificationRoute($postVerificationRoute)
    {
        $this->postVerificationRoute = $postVerificationRoute;

        return $this;
    }

    public function getPostVerificationRoute()
    {
        return $this->postVerificationRoute;
    }
}
