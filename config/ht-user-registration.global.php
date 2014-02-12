<?php

return array(
    'email_from_address' => array(
        'email' => 'You@domain.com',
        'name' => 'Your Name Please'
    ),
    'verification_email_template' => 'ht-user-registration/mail/verify-email.phtml',
    'password_request_email_template' => 'ht-user-registration/mail/set-password.phtml',
    'email_transport' => 'Zend\Mail\Transport\Sendmail',
    'enable_request_expiry' => false,
    'request_expiry' => 86400,
    'request_table_name' => 'user_registration',
    'request_entity_class' => 'HtUserRegistration\Entity\UserRegistration',
    'send_verification_email' => true,
    'send_password_request_email' => true,
    'verification_email_subject' => 'Email Address Verification',
    'password_request_email_subject' => 'Set Your Password',
);
