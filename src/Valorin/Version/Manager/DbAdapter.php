<?php
/**
 * ValVersion - ZF2 Version Module
 * A simple database versioning system for ZF2 applications.
 *
 * Copyright (c) 2012, Stephen Rees-Carter <http://stephen.rees-carter.net/>
 * New BSD Licence, see LICENCE.txt
 */

namespace ValVersion\Manager;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;

class DbAdapter extends ManagerAbstract
{
    /**
     * @var String
     */
    const VERSION_TABLE = 'valversion';

    /**
     * @var String
     */
    protected $name = "ZF DbAdapter";

    /**
     * @var Adapter
     */
    protected $adapter;


    /**
     * Returns true if the adapter is configured
     *
     * @return Boolean
     */
    public function hasAdapter()
    {
        return $this->sm->has('Zend\Db\Adapter\Adapter');
    }


    /**
     * Returns the database adapter
     *
     * @return Class
     */
    public function getAdapter()
    {
        if (!$this->hasAdapter()) {
            return null;
        }

        if (!isset($this->adapter)) {
            $this->adapter = $this->sm->get('Zend\Db\Adapter\Adapter');
        }

        return $this->adapter;
    }


    /**
     * Returns the current version number from the adapter
     * (or null if not installed)
     *
     * @return Integer
     */
    public function getCurrent()
    {
        /**
         * Retrieve latest version number
         */
        $sql    = new Sql($this->getAdapter());
        $select = $sql->select(self::VERSION_TABLE);
        $select->limit(1)->order("id DESC");

        try {
            $row = $sql->prepareStatementForSqlObject($select)->execute()->current();
        } catch (\Exception $exception) {
            return null;
        }

        return $row ? $row['version'] : null;
    }


    /**
     * Update the version tracker to the specified version
     *
     * @param  Integer $version
     * @return ManagerInterface
     */
    public function setVersion($version)
    {
        /**
         * Ensure table exists
         */
        $this->ensureTableExists();


        /**
         * Insert record
         */
        $sql    = new Sql($this->getAdapter());
        $insert = $sql->insert(self::VERSION_TABLE)->values(Array('version' => $version));
        $sql->prepareStatementForSqlObject($insert)->execute();

        return $this;
    }


    /**
     * Ensures the db version number table exists
     *
     * @return DbAdapter
     */
    protected function ensureTableExists()
    {
        $adapter = $this->getAdapter();
        $sql     = "CREATE TABLE IF NOT EXISTS `".self::VERSION_TABLE."` (
                      `id`      BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
                      `version` BIGINT UNSIGNED NOT NULL,
                      `applied` TIMESTAMP NOT NULL,
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin";
        $adapter->query($sql, Adapter::QUERY_MODE_EXECUTE);

        return $this;
    }
}
