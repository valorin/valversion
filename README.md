ZF2 Version Module
==================

Provides an easy database versioning system for ZF2 applications.

## Installation Instructions

Currently the version module only works via a web browser. When the ZF2 CLI is
implemented, I'm hoping it will provide a better (and more secure) interface.

Since this module allows an attacker to break your database over the web if they
gain access to it, we need to do something special to keep it secure.
The best solution is to only add it to the *'modules'* array in
`application.config.php` when you want to use it, and leave it out when you're
done. You can use a little magic to have the module added automatically only
when specific conditions are met.

This example uses an IP address and secret key to authenticate the request:

    <?php
    $aReturn = array(
        'modules' => array(
            // ...
        ),
        'module_listener_options' => array(
            // ...
        ),
    );

    $aAllowed = Array('127.0.0.1');
    $sKey     = "VERSION_ACCESS_KEY";
    if (in_array($_SERVER['REMOTE_ADDR'], $aAllowed)
        && isset($_GET['key']) && $_GET['key'] == $sKey) {
        $aReturn['modules'][] = 'Version';
    }

    return $aReturn;

*Note: the version module automatically detects the 'key' parameter and appends
it automatically to each url within the module.*

## Licence

See [LICENCE.txt](https://github.com/valorin/zf2-version-module/blob/master/LICENCE.txt).
