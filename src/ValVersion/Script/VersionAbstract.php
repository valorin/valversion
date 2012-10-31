<?php
/**
 * ValVersion - ZF2 Version Module
 * A simple database versioning system for ZF2 applications.
 *
 * Copyright (c) 2012, Stephen Rees-Carter <http://stephen.rees-carter.net/>
 * New BSD Licence, see LICENCE.txt
 */

namespace ValVersion\Script;

abstract class VersionAbstract
{
    /**
     * Constructor
     *
     * @param ScriptGateway $scriptGateway
     */
    public function __construct($scriptGateway)
    {
        $this->scriptGateway = $scriptGateway;
    }
}
