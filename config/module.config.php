<?php
return array(
    'valcommon' => Array(
        'setting' => Array(
            'valversion_version'     => "v0.0.1",
            'valversion_scripts_dir' => __DIR__.'/../../../data/versions',
        ),
    ),
    'di' => array(
        'instance' => array(
            'alias' => array(
                'version' => 'ValVersion\Controller\VersionController',
            ),

            'ValVersion\Controller\VersionController' => array(
                'parameters' => array(
                    'oManager' => 'ValVersion\Model\Manager',
                ),
            ),
            'ValVersion\Model\Manager' => array(
                'parameters' => array(
                    'oDb'    => 'Zend\Db\Adapter\Adapter',
                    'oTable' => 'ValVersion\Model\VersionHistoryTable',
                ),
            ),
            'ValVersion\Model\VersionHistoryTable' => array(
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
