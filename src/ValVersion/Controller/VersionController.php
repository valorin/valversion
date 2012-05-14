<?php
namespace ValVersion\Controller;
use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel,
    ValVersion\Model\Manager;

/**
 * Story Module - Page Controller
 *
 * Retrieves, creates, and edits, Story Pages
 *
 * @package     ValVersion
 * @subpackage  ValVersion\Controller
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
         * Set Layout Parameters
         */
        $this->_setLayoutParams();


        /**
         * Set view params
         */
        return Array(
            'bUpgrade' => $this->_oManager->canUpgrade()
        );
    }


    /**
     * Upgrades the database to latest
     *
     */
    public function upgradeAction()
    {
        /**
         * Set Layout Parameters
         */
        $this->_setLayoutParams();


        /**
         * Run Upgrade
         */
        $aApplied = $this->_oManager->upgrade();

        return Array('aApplied' => $aApplied);
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


    /**
     * Set the layout parameters
     *
     */
    protected function _setLayoutParams()
    {
        $this->layout()->oManager = $this->_oManager;
        $this->layout()->sKey     = $this->getRequest()->query()->get("key");
    }
}
