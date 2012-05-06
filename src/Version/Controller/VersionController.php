<?php
namespace Version\Controller;
use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel,
    Zend\Db\Adapter\Adapter;

/**
 * Story Module - Page Controller
 *
 * Retrieves, creates, and edits, Story Pages
 *
 * @package     zf2-version-module
 * @subpackage  Version\Controller
 * @copyright   Copyright (c) 2012, Stephen Rees-Carter <http://src.id.au/>
 * @license     New BSD Licence, see LICENCE.txt
 */
class VersionController extends ActionController
{
    /**
     * @var Adapter
     */
    protected $_oDb;


    /**
     * Index Action
     *
     */
    public function indexAction()
    {
    }


    /**
     * Inject Db Adapter
     *
     * @param  Adapter  $oDb    Database Adapter
     */
    public function setAdapter(Adapter $oDb)
    {
        $this->_oDb = $oDb;
        return $this;
    }
}
