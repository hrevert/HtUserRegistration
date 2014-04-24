<?php
namespace HtUserRegistration\Mailer;

use HtUserRegistration\Entity\UserRegistrationInterface;
use HtUserRegistration\Options\ModuleOptions;
use GoalioMailService\Mail\Service\Message as MailService;

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

        $message = $this->mailService->createHtmlMessage(
            $this->getOptions()->getEmailFromAddress(),
            $user->getEmail(),
            $subject,
            $template,
            ['user' => $user, 'registrationRecord' => $registrationRecord]
        );

        return $this->mailService->send($message);        
    }
}
