<?php
namespace Version\Controller;
use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel,
    Version\Model\Manager;

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
     * @var Manager
     */
    protected $_oManager;


    /**
     * Index Action
     *
     */
    public function indexAction()
    {
        /**
         * Send Version Manager to the layout
         */
        $this->layout()->oManager = $this->_oManager;
    }


    /**
     * Inject Version Manager
     *
     * @param  Manager  $oManager   Version Manager
     */
    public function setAdapter(Manager $oManager)
    {
        /**
         * Save
         */
        $this->_oManager = $oManager;


        /**
         * Return self
         */
        return $this;
    }
}
