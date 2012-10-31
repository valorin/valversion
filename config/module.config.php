<?php
return array(
    'valversion' => Array(
        'managers' => Array(
            'DbAdapter' => 'ValVersion\Manager\DbAdapter',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'ValVersion\Controller\Version' => 'ValVersion\Controller\VersionController',
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'status' => array(
                    'options' => array(
                        'route'    => 'version status [--verbose|-v]',
                        'defaults' => array(
                            'controller' => 'ValVersion\Controller\Version',
                            'action'     => 'status'
                        )
                    )
                ),
                'upgrade' => array(
                    'options' => array(
                        'route'    => 'version upgrade [<target>] [--verbose|-v]',
                        'defaults' => array(
                            'controller' => 'ValVersion\Controller\Version',
                            'action'     => 'upgrade'
                        )
                    )
                ),
                'downgrade' => array(
                    'options' => array(
                        'route'    => 'version downgrade <target> [--verbose|-v]',
                        'defaults' => array(
                            'controller' => 'ValVersion\Controller\Version',
                            'action'     => 'downgrade'
                        )
                    )
                ),
            )
        )
    )
);
