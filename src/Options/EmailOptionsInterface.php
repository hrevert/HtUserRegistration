<?php
namespace HtUserRegistration\Options;

interface EmailOptionsInterface
{
    public function getEmailFromAddress() ;

    public function getEmailTransport();
}
