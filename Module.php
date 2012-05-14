<?php
namespace ValVersion;
use Zend\Module\Consumer\AutoloaderProvider;

/**
 * ZF2 Version Module
 *
 * Provides an easy database versioning system for ZF2 applications.
 *
 * @package     ValVersion
 * @subpackage  ValVersion\Module
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class Module implements AutoloaderProvider
{
    /**
     * Autoloader config
     *
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }


    /**
     * Get module config
     *
     */
    public function getConfig($env = null)
    {
        return include __DIR__ . '/config/module.config.php';
    }
}
