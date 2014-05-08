<?php
namespace HtUserRegistration\Mailer;

use HtUserRegistration\Entity\UserRegistrationInterface;
use HtUserRegistration\Options\ModuleOptions;
use MtMail\Service\Mail as MailService;

class Mailer implements MailerInterface
{
    /**
     * @var ModuleOptions
     */
    protected $options;

    /**
     * @var MailService
     */
    protected $mailService;

    /**
     * Constructor
     *
     * @param ModuleOptions $options
     * @param MailService $mailService
     */
    public function __construct(ModuleOptions $options, MailService $mailService)
    {
        $this->options = $options;
        $this->mailService = $mailService;
    }

    public function getOptions()
    {
        return $this->options;
    }

    /**
     * {@inheritDoc}
     */
    public function sendVerificationEmail(UserRegistrationInterface $registrationRecord)
    {
        $this->sendMail(
            $registrationRecord, 
            $this->getOptions()->getVerificationEmailSubject(), 
            $this->getOptions()->getVerificationEmailTemplate()
        );
    }

    /**
     * {@inheritDoc}
     */
    public function sendPasswordRequestEmail(UserRegistrationInterface $registrationRecord)
    {
        $this->sendMail(
            $registrationRecord, 
            $this->getOptions()->getPasswordRequestEmailSubject(), 
            $this->getOptions()->getPasswordRequestEmailTemplate()
        );        
    }

    /**
     * Sends mail
     *
     * @param UserRegistrationInterface $registrationRecor
     * @param string $subject
     * @param string $template
     */
    protected function sendMail(UserRegistrationInterface $registrationRecord, $subject, $template)
    {
        $user = $registrationRecord->getUser();
        $message = $this->mailService->compose(
            ['to' => $user->getEmail()], 
            $template, 
            ['user' => $user, 'registrationRecord' => $registrationRecord]
        );
        if ($this->getOptions()->getEmailFromAddress()) {
            $message->setFrom($this->getOptions()->getEmailFromAddress());
        }
        $message->setSubject($subject);

        return $this->mailService->send($message);        
    }
}
