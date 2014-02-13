<?php
namespace HtUserRegistration\Options;

interface DatabaseOptionsInterface
{
    public function getRequestTableName();

    public function getRequestEntityClass();
}
