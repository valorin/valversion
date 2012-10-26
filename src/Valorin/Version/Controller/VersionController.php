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
     * @var String
     */
    protected $header = "\n=====================\n== Version Manager ==\n=====================\n";

    /**
     * @var DbAdapterManager
     */
    protected $dbAdapterManager;


    /**
     * Display the current status of the application version.
     *
     * @return String
     * @throws RuntimeException
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
         * Output header
         */
        $output  = $this->header;
        $output .= "\nApplication version status:\n\n";


        /**
         * Loop Managers
         */
        $managers = $this->getConfig('managers');
        foreach ($managers as $manager) {
            $class   = new $manager($this->getServiceLocator());
            $output .= $class->getStatus()."\n";
        }

        return $output;
    }


    /**
     * Upgrade the application
     *
     * @return String
     * @throws RuntimeException
     */
    public function upgradeAction()
    {
        /**
         * Get Request & verify ConsoleRequest
         */
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException(self::NOTCONSOLE);
        }


        /**
         * Prepare variables
         */
        $managers = $this->getConfig('managers');
        $target   = $request->getParam('target');


        /**
         * Output depending on target
         */
        $output = $this->header;
        if (is_null($target)) {
            $output .= "\nUpgrading version to latest.\n\n";
        } else {
            $output .= "\nUpgrading version to target (#{$target}).\n\n";
        }


        /**
         * Upgrade each manager
         */
        foreach ($managers as $manager) {
            $class   = new $manager($this->getServiceLocator());
            $output .= $class->upgrade($target);
        }

        return $output."\n";
    }


    /**
     * Downgrade the application
     *
     * @return String
     * @throws RuntimeException
     */
    public function downgradeAction()
    {
        /**
         * Get Request & verify ConsoleRequest
         */
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException(self::NOTCONSOLE);
        }

        return "Not implemented yet, sorry...\n";
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
