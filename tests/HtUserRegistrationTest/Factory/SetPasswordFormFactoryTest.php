<?php

namespace HtUserRegistrationTest\Factory;

use Zend\ServiceManager\ServiceManager;
use HtUserRegistration\Factory\SetPasswordFormFactory;
use Zend\Form\Form;

class SetPasswordFormFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function testFactory()
    {
        $form = new Form;
        $serviceManager = new ServiceManager;
        $serviceManager->setService('zfcuser_change_password_form', $form);
        $factory = new SetPasswordFormFactory;
        $this->assertInstanceOf('Zend\Form\Form', $factory->createService($serviceManager));
    }
}
