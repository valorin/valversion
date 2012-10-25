<?php
/**
 * Copyright (c) 2012, InterSect Alliance International Pty Ltd
 * http://www.intersectalliance.com/
 *
 * All rights reserved. Unauthorised distribution is prohibited.
 */

namespace Valorin\Version\Controller;

use Zend\Console\ColorInterface as Colour;
use Zend\Console\Prompt;
use Zend\Console\Request as ConsoleRequest;
use Zend\Mvc\Controller\AbstractActionController;

class VersionController extends AbstractActionController
{
    /**
     * @var String
     */
    const NOTCONSOLE = 'You can only use this action from a console!';


    /**
     * Display the current status of the application version.
     *
     * @return String
     */
    public function statusAction()
    {
        /**
         * Get Request & verify ConsoleRequest
         */
        $request = $this->getRequest();

        if (!$request instanceof ConsoleRequest) {
            throw new \RuntimeException(self::NOTCONSOLE);
        }


        return "Hello!\n\n";
    }
}
