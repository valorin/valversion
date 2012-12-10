ZF2 Version Module v2
=====================

**I've stopped working on this module because I found [Phinx](https://github.com/robmorgan/phinx), a fantastic DB Migration tool. I recommend you use it!**

*I'm working on ZF2 Module to integrate it into a ZF2 application: [zf2-phinx-module](https://github.com/valorin/zf2-phinx-module/).*

Legacy information
------------------


A simple versioning system for ZF2 applications using the `Zend\Console` package to
provide a secure way to manage versions.
It currently supports the `Zend\Db\Adapter` class for database management, although
it has been built to handle other adapter modules if required.
*(Feel free to implement your own and make a Pull Request.)*

**IMPORTANT: This module is still very much in development.**

## Installation Instructions

1. Install [compser](http://getcomposer.org/doc/00-intro.md), and add `"valorin/version": "dev-master"` to your `./composer.json`:

    ```json
    {
        "require": {
            "valorin/version": "dev-master"
        }
    }
    ```

2. Run `./composer.phar install` to download the module into your application.

3. Add the module (`ValVersion`) `config/application.config.php`:

    ```php
    <?php
    return array(
        // ...
        'modules' => array(
            'Application',
            // ...
            'ValVersion',
        ),
        // ...
    );
    ```

4. Add the configuration to `config/autoload/global.php`, updating paths as required:

    ```php
    <?php
    return array(
        // ...
        'valversion' => Array(
            'DbAdapter' => Array(
                'class_dir'       => __DIR__ ."/../../data/versions",
                'class_namespace' => "\Application\Version",
            ),
        ),
        // ...
    );
    ```

5. Create version scripts in your specified `class_dir`, following the template:

    ```
    Filename: [#version]-[ClassName].php
    i.e:     0-CreateStructure.php
    ```

    ```php
    <?php
    namespace Application\Version;

    use ValVersion\Script\VersionAbstract;

    class CreateStructure extends VersionAbstract
    {
        public function upgrade($adapter)
        {
            $sql = Array(
                "CREATE TABLE `table1` (
                  // ...
                )",

                "CREATE TABLE `table2` (
                  // ...
                )",
            );

            foreach ($sql as $query) {
                $adapter->query($query, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            }

            return true;
        }


        public function downgrade($adapter)
        {
            $sql = Array(
                "DROP TABLE IF EXISTS `table1`",
                "DROP TABLE IF EXISTS `table2`",
            );


            foreach ($sql as $query) {
                $adapter->query($query, \Zend\Db\Adapter\Adapter::QUERY_MODE_EXECUTE);
            }

            return true;
        }
    }
   ```

6. Version Management should now be available via the ZF Console interface.

    ```bash
    valorin@gandalf:~/workspace/zf$ php ./public/index.php
    > ValVersion module v2.0.0 alpha

    Version Management
      index.php version status              Display the current version status of application.
      index.php version upgrade             Upgrade the application to the latest version.
      index.php version upgrade   TARGET    Upgrade the application to the specified version.
      index.php version downgrade TARGET    Downgrade the application to the specified version.
    ```

Have fun :)


## Licence

See [LICENCE.txt](https://github.com/valorin/valversion/blob/master/LICENCE.txt).
