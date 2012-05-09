<?php
return array(
    'version' => Array(
        'module_version' => "v0.0.1",
    ),
    'di' => array(
        'instance' => array(
            'alias' => array(
                'version' => 'Version\Controller\VersionController',
            ),

            'Version\Controller\VersionController' => array(
                'parameters' => array(
                    'oManager' => 'Version\Model\Manager',
                ),
            ),
            'Version\Model\Manager' => array(
                'parameters' => array(
                    'oDb'    => 'Zend\Db\Adapter\Adapter',
                    'oTable' => 'Version\Model\VersionHistoryTable',
                ),
            ),
            'Version\Model\VersionHistoryTable' => array(
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
            // Defining where the layout/layout view should be located
            'Zend\View\Resolver\TemplateMapResolver' => array(
                'parameters' => array(
                    'map'  => array(
                        'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
                    ),
                ),
            ),
            // View for the layout
            'Zend\Mvc\View\DefaultRenderingStrategy' => array(
                'parameters' => array(
                    'layoutTemplate' => 'layout/layout',
                ),
            ),
        ),
    ),
);
