TurtlePHP-DatabasePlugin
======================

``` php
require_once APP . '/vendors/PHP-MySQL/MySQLConnection.class.php';
require_once APP . '/vendors/PHP-MySQL/MySQLQuery.class.php';
require_once APP . '/plugins/TurtlePHP-DatabasePlugin/Database.class.php';
\Plugin\Database::connect();
```

``` php
\Plugin\Database::setConfigPath('/path/to/config/file.inc.php');
\Plugin\Database::connect();
```
