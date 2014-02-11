<?php
namespace HtUserRegistration\Options;

class ModuleOptions
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
     * @var int
     */
    protected $requestExpiry = 86400; // 1 day

    /**
     * @var string
     */
    protected $requestEntityClass;

    
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
    
    public function setRequestExpiry($requestExpiry)
    {
        $this->requestExpiry = $requestExpiry;

        return $this;
    }
    
    public function getRequestExpiry()
    {
        return $this->requestExpiry;
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
              
}
