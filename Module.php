<?php
namespace ValVersion;
use Zend\Module\Manager,
    Zend\EventManager\StaticEventManager,
    Zend\Module\Consumer\AutoloaderProvider;

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
     * @var Array
     */
    protected static $_aOptions;


    /**
     * Initiate the module
     *
     * @param   Manager $oManager
     */
    public function init(Manager $oManager)
    {
        /**
         * Register Event for 'loadOptions'
         */
        $oManager->events()->attach('loadModules.post', array($this, 'loadOptions'));
    }


    /**
     * Loads the static config options
     *
     * @param   Zend\Module\ModuleEvent $oEvent
     */
    public function loadOptions($oEvent)
    {
        /**
         * Load Config Options
         */
        $aConfig = $oEvent->getConfigListener()->getMergedConfig();
        static::$_aOptions = $aConfig['valversion'];

    }


    /**
     * Retrieve option value
     *
     * @param   String  $sKey
     * @param   String  $xDefault
     */
    public static function getOption($sKey = null, $xDefault = null)
    {
        if (is_null($sKey)) {
            return static::$_aOptions;
        }

        if (!isset(static::$_aOptions[$sKey])) {
            return $xDefault;
        }
        return static::$_aOptions[$sKey];
    }


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
