<?php

namespace HtUserRegistration\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;

class SetPasswordFormFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $changePasswordForm = $serviceLocator->get('zfcuser_change_password_form');
        $form = clone $changePasswordForm;
        foreach (array('identity', 'credential') as $field) {
            $form->remove($field);
            $form->getInputFilter()->remove($field);
        }

        return $form;
    }
}
