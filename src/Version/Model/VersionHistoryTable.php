<?php
namespace Version\Model;

use Zend\Db\TableGateway\TableGateway,
    Zend\Db\Adapter\Adapter,
    Zend\Db\ResultSet\ResultSet;

/**
 * ZF2 Version Module - Version History table
 *
 * Manages the `version_history` table.
 *
 * @package     zf2-version-module
 * @subpackage  Version\Model
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class VersionHistoryTable extends TableGateway
{
    /**
     * Constructor
     *
     * @param Adapter   $oDb
     */
    public function __construct(Adapter $oDb)
    {
        /**
         * Run parent constructor
         */
        parent::__construct('version_history', $oDb);


        /**
         * Check if table exists
         */
        $this->_createIfNotExists();
    }

    /**
     * Returns the current version number
     *
     * @return  Integer
     */
    public function getCurrent()
    {
        /**
         * Build Select
         */
        $oSelect = clone $this->sqlSelectPrototype;
        $oSelect->order(Array("id DESC"))->fetch(1);
        return $this->selectWith($oSelect)->current();
    }


    /**
     * Checks the vesion table exists
     *
     */
    protected function _createIfNotExists()
    {
        /**
         * SQL create if not exists
         */
        $sSql = <<<SQL
CREATE TABLE IF NOT EXISTS `{$this->getTableName()}` (
    `id`            BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
    `version`       BIGINT UNSIGNED NOT NULL,
    `description`   VARCHAR(255) NOT NULL,
    `timestamp`     TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY (`version`)
) ENGINE=INNODB
SQL;

        $this->getAdapter()->query($sSql, Adapter::QUERY_MODE_EXECUTE);
    }
}
