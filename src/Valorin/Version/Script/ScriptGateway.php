<?php
/**
 * Valorin/Version - ZF2 Version Module
 * A simple database versioning system for ZF2 applications.
 *
 * Copyright (c) 2012, Stephen Rees-Carter <http://stephen.rees-carter.net/>
 * New BSD Licence, see LICENCE.txt
 */

namespace Valorin\Version\Script;

class ScriptGateway
{
    /**
     * @var Array
     */
    protected $config;

    /**
     * @var Array[integer=>VersionInterface]
     */
    protected $scripts;


    /**
     * Constructor
     *
     * @param  Array $config
     */
    public function __construct($config)
    {
        $this->config = $config;

        $this->parseScripts();
    }


    /**
     * Returns the latest version number
     *
     * @return Integer
     */
    public function getLatest()
    {
        $versions = array_keys($this->scripts);
        return array_pop($versions);
    }


    /**
     * Parses the version scripts and loads them for use
     *
     * @return Gateway
     * @throws VersionException
     */
    protected function parseScripts()
    {
        /**
         * Load scripts from 'class_dir'
         */
        if (!is_readable($this->config['class_dir'])) {
            throw new VersionException("Unable to read scripts dir: {$this->config['class_dir']}");
        }

        $scripts = scandir($this->config['class_dir']);


        /**
         * Loop and extract actual classes
         */
        $this->scripts = Array();
        foreach ($scripts as $file) {
            if (!preg_match("/^(\d+)-(\w+)\.php$/", $file, $matches)) {
                continue;
            }

            require_once $this->config['class_dir']."/".$file;
            $class = $this->config['class_namespace']."\\".$matches[2];
            $this->scripts[$matches[1]] = new $class($this);
        }

        return $this;
    }
}
