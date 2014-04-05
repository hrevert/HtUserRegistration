<?php
namespace HtUserRegistration\Options;

interface TemplateOptionsInterface
{
    public function getVerificationEmailTemplate();

    public function getPasswordRequestEmailTemplate();
}
