<?php
namespace Version\Model;
use Zend\Db\Adapter\Adapter;

/**
 * ZF2 Version Module - Abstract Version
 *
 * Version Script abstract class.
 *
 * @package     zf2-version-module
 * @subpackage  Version\Model
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
abstract class AbstractVersion
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
    public function __construct(Adapter $oDb)
    {
        /**
         * Save vars
         */
        $this->_oDb    = $oDb;
    }


    /**
     * Upgrade Script
     *
     * @return  Boolean
     */
    abstract public function upgrade();


    /**
     * Downgrade Script
     *
     * @return  Boolean
     */
    abstract public function downgrade();



    protected function _drop($sTable)
    {
        /**
         * Check for Array
         */
        if (is_array($sTable)) {
            foreach ($sTable as $sTbl) {
                $this->_drop($sTbl);
            }
            return;
        }


        /**
         * Drop the table
         */
        $sSql = "DROP TABLE `{$sTable}`";
        $this->_oDb->query($sSql, Adapter::QUERY_MODE_EXECUTE);
    }
}
