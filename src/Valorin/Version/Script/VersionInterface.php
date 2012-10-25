<?php
/**
 * Valorin/Version - ZF2 Version Module
 * A simple database versioning system for ZF2 applications.
 *
 * Copyright (c) 2012, Stephen Rees-Carter <http://stephen.rees-carter.net/>
 * New BSD Licence, see LICENCE.txt
 */

namespace Valorin\Version\Script;

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
     * @throws VersionException
     */
    public function upgrade();


    /**
     * Downgrade the application
     *
     * @throws VersionException
     */
    public function downgrade();
}
