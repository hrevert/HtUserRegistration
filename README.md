HtUserRegistration
===============

A Zend Framework 2 module which extends the registration feature of ZfcUser. When public registration is enabled, it provides email address verfication feature and when public registration is disabled, it sends email to the user`s email address with a link to set their account password.

## Installation

* Add "hrevert/ht-user-registration": "dev-master", to your composer.json and run `php composer.phar update` 
* Enable this module in config/application.config.php
* Copy file located in config/htprofileimage.global.php to ./config/autoload/ht-user-registration.global.php and change the values as you wish.

## Note
If you do not want unverified users to log in, this module also ships with a authentication adapter.
```php
return [
  'zfcuser' => [
    'auth_adapters' => [80 => 'HtUserRegistration\Authentication\Adapter\EmailVerification']
  ]
];
```
