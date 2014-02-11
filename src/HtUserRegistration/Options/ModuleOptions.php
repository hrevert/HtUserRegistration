<?php
namespace HtUserRegistration\Options;

class ModuleOptions implements 
    TemplateOptionsInterface, 
    RequestExpiryOptionsInterface, 
    EmailOptionsInterface, 
    FeatureOptionsInterface
{
    /**
     * @var string | array
     */
    protected $emailFromAddress = ''; 

    /**
     * @var string
     */
    protected $verificationEmailTemplate = '';

    /**
     * @var string
     */
    protected $passwordRequestEmailTemplate = '';

    /**
     * @var string
     */
    protected $emailTransport = 'Zend\Mail\Transport\Sendmail';

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
    protected $requestTableName = 'user_registration';

    /**
     * @var string
     */
    protected $requestEntityClass = 'HtUserRegistration\Entity\UserRegistration';

    /**
     * @var boolean
     */
    protected $sendVerificationEmail = true;

    /**
     * @var boolean
     */
    protected $sendPasswordRequestEmail = true;

    
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

	public function setEmailTransport($emailTransport) 
    {
        $this->emailTransport = $emailTransport;

        return $this;
    }
    
    public function getEmailTransport()
    {
        return $this->emailTransport;
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

    public function setRequestTableName($requestTableName)
    {
        $this->requestTableName = $requestTableName;

        return $this->this;
    }

    public function getRequestTableName()
    {
        return $this->requestTableName;
    }
    
    public function setRequestEntityClass($requestEntityClass)
    {
        $this->requestEntityClass = $requestEntityClass;

        return $this;
    } 
    
    public function getRequestEntityClass()
    {
        return $this->requestEntityClass;
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
}
