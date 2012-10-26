<?php
return array(
    'valorin' => Array(
        'version' => Array(
            'managers' => Array(
                'DbAdapter' => 'Valorin\Version\Manager\DbAdapter',
            ),
        ),
    ),
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
                        'route'    => 'version upgrade [<target>] [--verbose|-v]',
                        'defaults' => array(
                            'controller' => 'Valorin\Version\Controller\Version',
                            'action'     => 'upgrade'
                        )
                    )
                ),
                'downgrade' => array(
                    'options' => array(
                        'route'    => 'version downgrade <target> [--verbose|-v]',
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
