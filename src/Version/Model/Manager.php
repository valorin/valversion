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
}
