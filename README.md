TurtlePHP-DatabasePlugin
======================

### Sample plugin loading:
``` php
require_once APP . '/vendors/PHP-MySQL/MySQLConnection.class.php';
require_once APP . '/vendors/PHP-MySQL/MySQLQuery.class.php';
require_once APP . '/plugins/TurtlePHP-BasePlugin/Base.class.php';
require_once APP . '/plugins/TurtlePHP-DatabasePlugin/Database.class.php';
$path = APP . '/config/plugins/database.inc.php';
Plugin\Database::setDatabasePath($path);
Plugin\Database::init();
```
