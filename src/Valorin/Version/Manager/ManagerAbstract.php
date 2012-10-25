<?php
/**
 * Valorin/Version - ZF2 Version Module
 * A simple database versioning system for ZF2 applications.
 *
 * Copyright (c) 2012, Stephen Rees-Carter <http://stephen.rees-carter.net/>
 * New BSD Licence, see LICENCE.txt
 */

namespace Valorin\Version\Manager;

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
        $output = "    {$this->name}: ";


        /**
         * Check for adapter
         */
        if (!$this->hasAdapter()) {
            return $output."not configured in application.\n";
        }


        /**
         * Check for version information
         */
        $latest = $this->getCurrentVersion();

        if (is_null($latest)) {
            return $output."configured but not installed, use 'upgrade' to install.\n";
        }

        return $output."version #{$latest} found.\n";
    }
}
