<?php
/**
 * Valorin/Version - ZF2 Version Module
 * A simple database versioning system for ZF2 applications.
 *
 * Copyright (c) 2012, Stephen Rees-Carter <http://stephen.rees-carter.net/>
 * New BSD Licence, see LICENCE.txt
 */

namespace Valorin\Version\Controller;

use Valorin\Version\Manager\DbAdapter as DbAdapterManager;
use Valorin\Version\Script\ScriptGateway;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\Controller\AbstractActionController;

class VersionController extends AbstractActionController
{
    /**
     * @var String
     */
    const NOTCONSOLE = 'You can only use this action from a console!';

    /**
     * @var DbAdapterManager
     */
    protected $dbAdapterManager;


    /**
     * Display the current status of the application version.
     *
     * @return String
     */
    public function statusAction()
    {
        /**
         * Get Request & verify ConsoleRequest
         */
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException(self::NOTCONSOLE);
        }


        /**
         * Load enabled managers
         */
        $managers = $this->getConfig('managers');


        /**
         * Output header
         */
        $output  = "\n=====================";
        $output .= "\n== Version Manager ==";
        $output .= "\n=====================";
        $output .= "\n\nChecking application version status\n\n";


        /**
         * Check the Scripts for the latest version
         */
        $output .= "    Latest version: ";
        $output .= $this->getScriptGateway()->getLatest();
        $output .= "\n\n";


        /**
         * Check each manager for status
         */
        $sm = $this->getServiceLocator();
        foreach ($managers as $manager) {
            $class   = $sm->get("Valorin\Version\Manager\\{$manager}");
            $output .= $class->getStatus();
        }

        return $output."\n";
    }


    /**
     * Retrieve config values, optionally only the specified key
     *
     * @param  String $key Config key to return
     * @return Array
     */
    public function getConfig($key = null)
    {
        $config = $this->getServiceLocator()->get('Config');

        if (!is_null($key)) {
            if (isset($config['valorin']['version'][$key])) {
                return $config['valorin']['version'][$key];
            }
            return null;
        }

        return $config['valorin']['version'];
    }


    /**
     * Retrieve the ScriptGateway from the servicemanager
     *
     * @return ScriptGateway
     */
    public function getScriptGateway()
    {
        return $this->getServiceLocator()->get('Valorin\Version\Script\ScriptGateway');
    }
}
