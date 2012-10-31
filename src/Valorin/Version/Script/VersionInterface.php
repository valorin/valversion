<?php
/**
 * ValVersion - ZF2 Version Module
 * A simple database versioning system for ZF2 applications.
 *
 * Copyright (c) 2012, Stephen Rees-Carter <http://stephen.rees-carter.net/>
 * New BSD Licence, see LICENCE.txt
 */

namespace ValVersion\Script;

interface VersionInterface
{
    /**
     * @var ScriptGateway
     */
    protected $scriptGateway;


    /**
     * Constructor
     *
     * @param ScriptGateway $scriptGateway
     */
    public function __construct($scriptGateway);


    /**
     * Upgrade the application
     *
     * @param  Class   $adapter (optional) Adapter to apply upgrades on
     * @return Boolean
     * @throws VersionException
     */
    public function upgrade($adapter = null);


    /**
     * Downgrade the application
     *
     * @param  Class   $adapter (optional) Adapter to apply downgrades on
     * @return Boolean
     * @throws VersionException
     */
    public function downgrade($adapter = null);
}
