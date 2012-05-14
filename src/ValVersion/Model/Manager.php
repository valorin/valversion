<?php
namespace ValVersion\Model;
use Zend\Db\Adapter\Adapter,
    ValVersion\Model\VersionHistoryTable,
    ValVersion\Module;

/**
 * ZF2 Version Module - Manager
 *
 * Manages the version up/down-grade process.
 *
 * @package     ValVersion
 * @subpackage  ValVersion\Model
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class Manager
{
    /**
     * @var Adapter
     */
    protected $_oDb;

    /**
     * @var Array
     */
    protected $_aScripts = Array();


    /**
     * Constructor
     *
     * @param  Adapter  $oDb    Database Adapter
     */
    public function __construct(Adapter $oDb, VersionHistoryTable $oTable)
    {
        /**
         * Save vars
         */
        $this->_oDb    = $oDb;
        $this->_oTable = $oTable;
    }


    /**
     * Checks if there is a new version/upgrade which can be applied
     *
     * @return  Boolean
     */
    public function canUpgrade()
    {
        return ($this->getCurrent() < $this->getLatest());
    }


    /**
     * Returns the current version number
     *
     * @return  Integer
     */
    public function getCurrent()
    {
        $oCurrent = $this->_oTable->getCurrent();
        return $oCurrent ? $oCurrent->version : 0;
    }


    /**
     * Returns the latest available version number
     *
     * @return  Integer
     */
    public function getLatest()
    {
        /**
         * Retrieve available version scripts
         */
        $aScripts = $this->listScripts();


        /**
         * Work out the latest version number
         */
        $aScripts = array_flip($aScripts);
        return array_pop($aScripts);
    }


    /**
     * Lists the available version scripts
     *
     * @return  Array
     */
    public function listScripts()
    {
        /**
         * Check cached
         */
        if (count($this->_aScripts)) {
            return $this->_aScripts;
        }


        /**
         * Check we can read dir
         */
        $sDir = Module::getOption('scripts_dir');
        if (!is_dir($sDir)) {
            return Array();
        }


        /**
         * Open Dir
         */
        if (!($rDir = opendir($sDir))) {
            return Array();
        }


        /**
         * Loop cersion scripts
         */
        $aScripts = Array();
        while ($sFile = readdir($rDir)) {
            if (preg_match('^(\d*)\-(\w*)\.php^', $sFile, $aMatches)) {
                $aScripts[$aMatches[1]] = $aMatches[2];
            }
        }


        /**
         * Close the directory like a good little programmer
         */
        closedir($rDir);

        ksort($aScripts, SORT_NUMERIC);
        $this->_aScripts = $aScripts;
        return $aScripts;
    }
}
