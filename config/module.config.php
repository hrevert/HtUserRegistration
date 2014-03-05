<?php
return [
    'view_manager' => [
        'template_path_stack' => [
            'HtUserRegistration' => __DIR__ . '/../view',
        ],
    ],
    'controllers' => [
        'factories' => [
            'HtUserRegistration' => 'HtUserRegistration\Controller\Factory\UserRegistrationFactory'
        ]
    ],
    'router' => [
        'routes' => [
            'zfcuser' => [
                'child_routes' => [
                    'verify_email' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/verify-email/:userId/:token',
                            'defaults' => [
                                'controller'    => 'HtUserRegistration',
                                'action'        => 'verify-email'
                            ]
                        ]
                    ],
                    'set_password' => [
                        'type' => 'Segment',
                        'options' => [
                            'route' => '/set-password/:userId/:token',
                            'defaults' => [
                                'controller'    => 'HtUserRegistration',
                                'action'        => 'set-password'
                            ]
                        ]
                    ],
                ]
            ]
        ]
    ],
    'ht_user_registration' => []
];
