<?php
namespace HtUserRegistrationTest\Options;

use HtUserRegistration\Options\ModuleOptions;

class ModuleOptionsTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultValues()
    {
        $options = new ModuleOptions;
        $this->assertEquals('', $options->getEmailFromAddress());
        $this->assertEquals('ht-user-registration/mail/verify-email.phtml', $options->getVerificationEmailTemplate());
        $this->assertEquals('ht-user-registration/mail/set-password.phtml', $options->getPasswordRequestEmailTemplate());
        $this->assertEquals(false, $options->getEnableRequestExpiry());
        $this->assertEquals(86400, $options->getRequestExpiry());
        $this->assertEquals('user_registration', $options->getRegistrationTableName());
        $this->assertEquals('HtUserRegistration\Entity\UserRegistration', $options->getRegistrationEntityClass());
        $this->assertEquals(true, $options->getSendVerificationEmail());
        $this->assertEquals(true, $options->getSendPasswordRequestEmail());
        $this->assertEquals('Email Address Verification', $options->getVerificationEmailSubject());
        $this->assertEquals('Set Your Password', $options->getPasswordRequestEmailSubject());
        $this->assertEquals('zfcuser/login', $options->getPostVerificationRoute());
    }

    public function testSettersAndGetters()
    {
        $options = new ModuleOptions([
            'emailFromAddress' => 'your_email_address@here.com',
            'verification_email_template' => 'application/mail/verify-email.phtml', 
            'password_request_email_template' => 'application/mail/set-password.phtml', 
            'enable_request_expiry' => true,
            'request_expiry' => 1000000,
            'registration_table_name' => 'user_registration123', 
            'registration_entity_class' => 'Application\Entity\UserRegistration',  
            'send_verification_email' => false,
            'send_password_request_email' => false,
            'verification_email_subject' => 'Your Email Address Verification',
            'password_request_email_subject' => 'Please Set Your Password',
            'post_verification_route' => 'zfcuser'  
        ]);
        $this->assertEquals('your_email_address@here.com', $options->getEmailFromAddress());
        $this->assertEquals('application/mail/verify-email.phtml', $options->getVerificationEmailTemplate());
        $this->assertEquals('application/mail/set-password.phtml', $options->getPasswordRequestEmailTemplate());
        $this->assertEquals(true, $options->getEnableRequestExpiry());
        $this->assertEquals(1000000, $options->getRequestExpiry());
        $this->assertEquals('user_registration123', $options->getRegistrationTableName());
        $this->assertEquals('Application\Entity\UserRegistration', $options->getRegistrationEntityClass());
        $this->assertEquals(false, $options->getSendVerificationEmail());
        $this->assertEquals(false, $options->getSendPasswordRequestEmail());
        $this->assertEquals('Your Email Address Verification', $options->getVerificationEmailSubject());
        $this->assertEquals('Please Set Your Password', $options->getPasswordRequestEmailSubject());
        $this->assertEquals('zfcuser', $options->getPostVerificationRoute());
    }
}
