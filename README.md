ZF2 Version Module v2
=====================

A simple database versioning system for ZF2 applications.

## Installation Instructions

1. Add to `composer.json`.

```json
    "require": {
        "valorin/version": "*"
    },
```

2. Run `composer.phar install` or `composer.phar update` to install in your application.

3. Add the module name (`Valorin\Version`) to `config/application.config.php`.

```php
<?php
return array(
    // ...
    'modules' => array(
        'Application',
        // ...
        'Valorin\Version',
    ),
    // ...
);
```

4. Add the version class configuration to `config/autoload/global.php`.
Updating the `class_dir` and `class_namespace` values as required.

```php
<?php
return array(
    // ...
    'valorin' => Array(
        'version' => Array(
            'class_dir'       => __DIR__ ."/../../data/versions",
            'class_namespace' => "\Application\Version",
        ),
    ),
    // ...
);
```

5. The available commands will be exposed via the standard ZF2 console.

```
valorin@gandalf:~/zf2/$ php ./public/index.php

Version Management
  index.php version status           [--verbose|-v]    Display the current version status of application.
  index.php version upgrade          [--verbose|-v]    Upgrade the application to the latest version.
  index.php version upgrade   NUMBER [--verbose|-v]    Upgrade the application to the specified version.
  index.php version downgrade NUMBER [--verbose|-v]    Downgrade the application to the specified version.

  --verbose    (optional) Output debugging information.
```

## Licence

See [LICENCE.txt](https://github.com/valorin/ValVersion/blob/master/LICENCE.txt).
