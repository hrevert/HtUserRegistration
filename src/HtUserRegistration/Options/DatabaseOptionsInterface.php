<?php
namespace HtUserRegistration\Options;

interface DatabaseOptionsInterface
{
    public function getRegistrationTableName();

    public function getRegistrationEntityClass();
}
