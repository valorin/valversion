<?php
namespace ValVersion\Model;
use Zend\Db\Adapter\Adapter;

/**
 * ZF2 Version Module - Abstract Version
 *
 * Version Script abstract class.
 *
 * @package     ValVersion
 * @subpackage  ValVersion\Model
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
        $this->_oDb = $oDb;
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


    /**
     * Insert multiple records into the database
     *
     * @param   String  $sTable     Table to insert records into
     * @param   Array   $aRecords   Records to insert
     */
    protected function _insert($sTable, $aRecords)
    {
        /**
         * Loop Records
         */
        foreach ($aRecords as $aRecord) {
            /**
             * Build SQL
             */
            $sSql  = "INSERT INTO `{$sTable}` ";
            $sSql .= "(`".implode("`, `", array_keys($aRecord))."`)";
            $sSql .= " VALUES ";
            $sSql .= "('".implode("', '", $aRecord)."')";

            $this->_oDb->query($sSql, Adapter::QUERY_MODE_EXECUTE);
        }
    }


    /**
     * Drop the specific table, or array of tables
     *
     * @param   String|Array    $sTable Table(s) to drop
     */
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
