<?php
namespace HtUserRegistration\Options;

interface FeatureOptionsInterface
{
    public function getSendVerificationEmail();

    public function getSendPasswordRequestEmail();
}
