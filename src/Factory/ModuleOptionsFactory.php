<?php

namespace HtUserRegistration\Factory;

use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\ServiceManager\FactoryInterface;
use HtUserRegistration\Options\ModuleOptions;

class ModuleOptionsFactory implements FactoryInterface {

    public function createService(ServiceLocatorInterface $serviceLocator) {
        $config = $serviceLocator->get('Config');

        return new ModuleOptions(isset($config['ht_user_registration']) ? $config['ht_user_registration'] : array());
    }

}
