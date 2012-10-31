<?php
/**
 * ValVersion - ZF2 Version Module
 * A simple database versioning system for ZF2 applications.
 *
 * Copyright (c) 2012, Stephen Rees-Carter <http://stephen.rees-carter.net/>
 * New BSD Licence, see LICENCE.txt
 */

namespace ValVersion\Manager;

use Zend\ServiceManager\ServiceManager;

interface ManagerInterface
{
    /**
     * Constructor
     *
     * @param ServiceManager $sm
     */
    public function __construct(ServiceManager $sm);


    /**
     * Upgrade the adapter to the target version
     *
     * @return String
     * @throws VersionException
     */
    public function upgrade($target = null);


    /**
     * Returns the current version status of the Adapter/Db/whatever
     *
     * @return String
     */
    public function getStatus();

    /**
     * Returns true if the adapter is configured
     *
     * @return Boolean
     */
    public function hasAdapter();


    /**
     * Returns the database adapter
     *
     * @return Class
     */
    public function getAdapter();


    /**
     * Returns the current version number from the adapter
     * (or null if not installed)
     *
     * @return Integer
     */
    public function getCurrent();


    /**
     * Returns the latest available version
     *
     * @return Integer
     */
    public function getLatest();


    /**
     * Update the version tracker to the specified version
     *
     * @param  Integer $version
     * @return ManagerInterface
     */
    public function setVersion($version);
}
