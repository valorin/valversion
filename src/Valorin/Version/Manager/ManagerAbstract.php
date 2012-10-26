<?php
/**
 * Valorin/Version - ZF2 Version Module
 * A simple database versioning system for ZF2 applications.
 *
 * Copyright (c) 2012, Stephen Rees-Carter <http://stephen.rees-carter.net/>
 * New BSD Licence, see LICENCE.txt
 */

namespace Valorin\Version\Manager;

use Valorin\Version\Script\ScriptGateway;
use Zend\ServiceManager\ServiceManager;

abstract class ManagerAbstract implements ManagerInterface
{
    /**
     * @var String
     */
    protected $name;

    /**
     * @var ServiceManager
     */
    protected $sm;

    /**
     * @var ScriptGateway
     */
    protected $scriptGateway;


    /**
     * Constructor
     *
     * @param ServiceManager $sm
     */
    public function __construct(ServiceManager $sm)
    {
        $this->sm = $sm;
    }


    /**
     * Returns the current version status of the Adapter/Db/whatever
     *
     * @return String
     */
    public function getStatus()
    {
        /**
         * Prefix with name
         */
        $output = $this->name."\n";


        /**
         * Check for adapter
         */
        if (!$this->hasAdapter()) {
            return $output."  Not configured in application.\n";
        }


        /**
         * Check for version information
         */
        $current = $this->getCurrent();

        if (is_null($current)) {
            return $output."  No versions installed.\n";
        }


        /**
         * Check version
         */
        $output .= "  Current version: #{$this->getCurrent()}\n";
        $output .= "  Latest version:  #{$this->getLatest()}\n";

        return $output;
    }


    /**
     * Returns the latest available version
     *
     * @return Integer
     */
    public function getLatest()
    {
        $scriptGateway = $this->getScriptGateway();

        $class   = explode("\\", get_class($this));
        $class   = end($class);
        return $scriptGateway->getLatest($class);
    }


    /**
     * Upgrade the adapter to the target version
     *
     * @param  Integer $target
     * @return String
     */
    public function upgrade($target = null)
    {
        /**
         * Prefix with name
         */
        $output = $this->name."\n";


        /**
         * Check for adapter
         */
        if (!$this->hasAdapter()) {
            return $output."  Not configured in application.\n";
        }


        /**
         * Check for version information
         */
        $scriptGateway = $this->getScriptGateway();

        $class   = explode("\\", get_class($this));
        $class   = end($class);
        $latest  = $scriptGateway->getLatest($class);
        $target  = $target ?: $latest;
        $current = $this->getCurrent();


        /**
         * Validate target
         */
        if ($target == $current && !is_null($current)) {
            return $output."  Target version matches current version, ignoring.\n";

        } elseif ($target < $current) {
            return $output."  Target version less than current version, use 'cli version downgrade TARGET'.\n";
        }


        /**
         * Perform the upgrade
         */
        $status = $this->doUpgrade($target);
        return $output.$status;
    }


    /**
     * Perform the actual upgrade
     *
     * @param  Integer $target
     * @return String
     */
    protected function doUpgrade($target)
    {
        /**
         * Retrieve scripts
         */
        $scriptGateway = $this->getScriptGateway();
        $class   = explode("\\", get_class($this));
        $class   = end($class);
        $scripts = $scriptGateway->getScripts($class);


        /**
         * Loop and upgrade
         */
        $start = is_null($this->getCurrent()) ? 0 : $this->getCurrent() + 1;
        for ($i = $start; $i <= $target; $i++) {
            if (isset($scripts[$i])) {
                if (!$scripts[$i]->upgrade($this->getAdapter())) {
                    return "  Upgrade failed at version #{$i}\n";
                }
            }

            $this->setVersion($i);
        }


        return "  Upgraded to version #{$this->getCurrent()}\n";
    }


    /**
     * Retrieve the ScriptGateway class
     *
     * @return ScriptGateway
     */
    protected function getScriptGateway()
    {
        if (!isset($this->scriptGateway)) {
            $this->scriptGateway = $this->sm->get('Valorin\Version\Script\ScriptGateway');
        }

        return $this->scriptGateway;
    }
}
