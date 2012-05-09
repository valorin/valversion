<?php
namespace Version\Model;
use Zend\Db\Adapter\Adapter,
    Version\Model\VersionHistoryTable;

/**
 * ZF2 Version Module - Manager
 *
 * Manages the version up/down-grade process.
 *
 * @package     zf2-version-module
 * @subpackage  Version\Model
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
        // TODO: Read files and fetch latest version number
        return 0;
    }
}
