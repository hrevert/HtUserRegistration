<?php
return array(
    'view_manager' => array(
        'template_path_stack' => array(
            'HtUserRegistration' => __DIR__ . '/../view',
        ),
    ),
    'controllers' => array(
        'factories' => array(
            'HtUserRegistration' => 'HtUserRegistration\Controller\Factory\UserRegistrationFactory'
        )
    ),
    'router' => array(
        'routes' => array(
            'zfcuser' => array(
                'child_routes' => array(
                    'verify_email' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/verify-email/:userId/:token',
                            'defaults' => array(
                                'controller'    => 'HtUserRegistration',
                                'action'        => 'verify-email'
                            )
                        )
                    ),
                    'set_password' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/set-password/:userId/:token',
                            'defaults' => array(
                                'controller'    => 'HtUserRegistration',
                                'action'        => 'set-password'
                            )
                        )
                    ),
                )
            )
        )
    ),
    'ht_user_registration' => []
);
