<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Valorin\Version\Controller\Version' => 'Valorin\Version\Controller\VersionController',
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'status' => array(
                    'options' => array(
                        'route'    => 'version status [--verbose|-v]',
                        'defaults' => array(
                            'controller' => 'Valorin\Version\Controller\Version',
                            'action'     => 'status'
                        )
                    )
                ),
                'upgrade' => array(
                    'options' => array(
                        'route'    => 'version upgrade [<number>] [--verbose|-v]',
                        'defaults' => array(
                            'controller' => 'Valorin\Version\Controller\Version',
                            'action'     => 'upgrade'
                        )
                    )
                ),
                'downgrade' => array(
                    'options' => array(
                        'route'    => 'version downgrade <number> [--verbose|-v]',
                        'defaults' => array(
                            'controller' => 'Valorin\Version\Controller\Version',
                            'action'     => 'downgrade'
                        )
                    )
                ),
            )
        )
    )
);
