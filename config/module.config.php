<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'version' => 'Version\Controller\VersionController',
            ),
            'Version\Controller\VersionController' => array(
                'parameters' => array(
                    'oDb' => 'Zend\Db\Adapter\Adapter',
                ),
            ),
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'album' => __DIR__ . '/../view',
                    ),
                ),
            ),
        ),
    ),
);
