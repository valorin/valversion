<?php
/**
 * Valorin/Version - ZF2 Version Module
 * A simple database versioning system for ZF2 applications.
 *
 * Copyright (c) 2012, Stephen Rees-Carter <http://stephen.rees-carter.net/>
 * New BSD Licence, see LICENCE.txt
 */

namespace Valorin\Version\Manager;

interface ManagerInterface
{
    /**
     * Returns true if the adapter is configured
     *
     * @return Boolean
     */
    public function hasAdapter();


    /**
     * Returns the current version number from the adapter
     * (or null if not installed)
     *
     * @return Integer
     */
    public function getCurrentVersion();
}
