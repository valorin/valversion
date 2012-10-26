<?php
/**
 * Valorin/Version - ZF2 Version Module
 *
 * A simple database versioning system for ZF2 applications.
 *
 * @package    Valorin\Version
 * @subpackage Valorin\Version\Module
 * @copyright  Copyright (c) 2012, Stephen Rees-Carter <http://stephen.rees-carter.net/>
 * @license    New BSD Licence, see LICENCE.txt
 */

namespace Valorin\Version;

use Valorin\Version\Manager\DbAdapter as DbAdapterManager;
use Valorin\Version\Script\ScriptGateway;
use Zend\Console\Adapter\AdapterInterface as Console;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\ConsoleUsageProviderInterface;
use Zend\ModuleManager\Feature\ConsoleBannerProviderInterface;

class Module implements
    ConfigProviderInterface,
    ConsoleUsageProviderInterface,
    ConsoleBannerProviderInterface
{
    /**
     * Returns the Service Manager Config
     *
     * @return Array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => Array(
                'Valorin\Version\Manager\DbAdapter' => function ($sm) {
                    return new DbAdapterManager($sm);
                },
                'Valorin\Version\Script\ScriptGateway' => function ($sm) {
                    $config = $sm->get('Config');
                    return new ScriptGateway($config['valorin']['version']);
                },
            ),
        );
    }


    /**
     * Returns the Module config Array
     *
     * @return Array
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }


    /**
     * Returns the Console Banner
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function getConsoleBanner(Console $console)
    {
        $version = trim(file_get_contents(__DIR__ ."/version.txt"));
        return "> Valorin/Version module v{$version}\n";
    }


    /**
     * Returns the Console Usage information
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     * @param  Console $console
     * @return Array
     */
    public function getConsoleUsage(Console $console)
    {
        return array(
            "Version Management",
            "version status"           => "Display the current version status of application.",
            "version upgrade"          => "Upgrade the application to the latest version.",
            "version upgrade   TARGET" => "Upgrade the application to the specified version.",
            "version downgrade TARGET" => "Downgrade the application to the specified version.",
            Array('--verbose', "(optional) Output debugging information."),
        );
    }
}
