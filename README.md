HtUserRegistration
===============

[![Master Branch Build Status](https://api.travis-ci.org/hrevert/HtUserRegistration.png)](http://travis-ci.org/hrevert/HtUserRegistration)
[![Latest Stable Version](https://poser.pugx.org/hrevert/ht-user-registration/v/stable.png)](https://packagist.org/packages/hrevert/ht-user-registration)
[![Latest Unstable Version](https://poser.pugx.org/hrevert/ht-user-registration/v/unstable.png)](https://packagist.org/packages/hrevert/ht-user-registration)
[![Total Downloads](https://poser.pugx.org/hrevert/ht-user-registration/downloads.png)](https://packagist.org/packages/hrevert/ht-user-registration)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/hrevert/HtUserRegistration/badges/quality-score.png?s=df5869789fc1c3925a7a4ebc5d6d3c13ca032975)](https://scrutinizer-ci.com/g/hrevert/HtUserRegistration/)

A Zend Framework 2 module which extends the registration feature of ZfcUser. When public registration is enabled, it provides email address verfication feature and when public registration is disabled, it sends email to the user`s email address with a link to set their account password.

## Installation

* Add `"hrevert/ht-user-registration": "dev-master"`, to your composer.json and run `php composer.phar update` 
* Enable this module in `config/application.config.php`
* Copy file located in `vendor/hrevert/ht-user-registration/config/ht-user-registration.global.php` to `./config/autoload/ht-user-registration.global.php` and change the values as you wish.
* Also, configure [MtMail](https://github.com/mtymek/MtMail/) as stated in the docs.

## Note
If you do not want unverified users to log in, this module also ships with a authentication adapter.
```php
return [
    'zfcuser' => [
        'auth_adapters' => [80 => 'HtUserRegistration\Authentication\Adapter\EmailVerification']
    ]
];
```
