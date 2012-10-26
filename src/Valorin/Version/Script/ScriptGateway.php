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
     * @param  String  $class Get latest version for class
     * @return Integer
     */
    public function getLatest($class)
    {
        $scripts  = $this->getScripts($class);
        $versions = array_keys($scripts);
        return array_pop($versions);
    }


    /**
     * Returns an Array of version scripts
     *
     * @param  String  $class Get latest version for class
     * @return Array
     * @throws VersionException
     */
    public function getScripts($class)
    {
        /**
         * Load scripts from 'class_dir'
         */
        if (!is_readable($this->config[$class]['class_dir'])) {
            throw new VersionException("Unable to read scripts dir: {$this->config[$class]['class_dir']}");
        }

        $dir = scandir($this->config[$class]['class_dir']);


        /**
         * Loop and extract actual classes
         */
        $scripts = Array();
        foreach ($dir as $file) {
            if (!preg_match("/^(\d+)-(\w+)\.php$/", $file, $matches)) {
                continue;
            }

            require_once $this->config[$class]['class_dir']."/".$file;
            $class = $this->config[$class]['class_namespace']."\\".$matches[2];
            $scripts[$matches[1]] = new $class($this);
        }

        return $scripts;
    }
}
