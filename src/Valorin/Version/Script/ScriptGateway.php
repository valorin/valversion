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
    }


    /**
     * Returns the latest version number
     *
     * @param  String  $manager Manager to query for latest version
     * @return Integer
     */
    public function getLatest($manager)
    {
        $scripts  = $this->getScripts($manager);
        $versions = array_keys($scripts);
        return array_pop($versions);
    }


    /**
     * Returns an Array of version scripts
     *
     * @param  String  $manager Manage to retrieve scripts for
     * @return Array
     * @throws VersionException
     */
    public function getScripts($manager)
    {
        /**
         * Load scripts from 'class_dir'
         */
        if (!is_readable($this->config[$manager]['class_dir'])) {
            throw new VersionException("Unable to read scripts dir: {$this->config[$manager]['class_dir']}");
        }

        $dir = scandir($this->config[$manager]['class_dir']);


        /**
         * Loop and extract actual classes
         */
        $scripts = Array();
        foreach ($dir as $file) {
            if (!preg_match("/^(\d+)-(\w+)\.php$/", $file, $matches)) {
                continue;
            }

            require_once $this->config[$manager]['class_dir']."/".$file;
            $class = $this->config[$manager]['class_namespace']."\\".$matches[2];
            $scripts[$matches[1]] = new $class($this);
        }

        return $scripts;
    }
}
