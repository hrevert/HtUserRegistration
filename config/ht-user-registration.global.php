<?php
/**
 * HtUserRegistration Configuration
 *
 * If you have a ./config/autoload/ directory set up for your project, you can
 * drop this config file in it and change the values as you wish.
 */

$options = array(
    /**
     * Email Address that will appear in the 'From' of outbound emails
     *
     * Default: empty
     */
    'email_from_address' => array(
        'email' => 'your_email_address@here.com',
        'name' => 'Your name',
    ),

    /**
     * Template for the verification email sent to users
     *
     * Default: ht-user-registration/mail/verify-email.phtml
     */
    'verification_email_template' => 'ht-user-registration/mail/verify-email.phtml',

    /**
     * Template for the password request email sent to users
     *
     * Default: ht-user-registration/mail/verify-email.phtml
     */
    'password_request_email_template' => 'ht-user-registration/mail/set-password.phtml',

    /**
     * Expire email link or not
     *
     * A token is sent in the emails sent to user. So do you want to enable expiry?
     *
     * Default: false
     *
     * Accepted values: boolean
     */
    'enable_request_expiry' => false,
    /**
     * Email Expiry in seconds
     *
     * Use this when email expiry is enabled
     *
     * Default: 86400(1 day)
     *
     * Accepted values: boolean
     */
    'request_expiry' => 86400,

    /**
     * Table Name
     *
     * Default: user_registration
     */
    'registration_table_name' => 'user_registration',
    /**
     * Entity Class
     *
     * Default: HtUserRegistration\Entity\UserRegistration
     */
    'registration_entity_class' => 'HtUserRegistration\Entity\UserRegistration',
    /**
     * Verification Email Send????
     *
     * Do you want this module to automatically send verification email when new user registered in ZfcUser?
     * Default: true
     */
    'send_verification_email' => true,
    /**
     * Send Password request email????
     *
     * Do you want this module to automatically send email with a link to set their account password?
     * You must disable public registration to use this feature?
     *
     * Default: true
     */
    'send_password_request_email' => true,
    /**
     * Subject of account verification email
     *
     */
    'verification_email_subject' => 'Email Address Verification',
    /**
     * Subject of Password request email
     *
     */
    'password_request_email_subject' => 'Set Your Password',

    /**
     * Post Verification route
     */
     'post_verification_route' => 'zfcuser/login'
);

/**
 * End of HtUserRegistration configuration
 */
return [
    'ht_user_registration' => $options
];
