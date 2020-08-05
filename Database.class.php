<?php

    // namespace
    namespace Plugin;

    /**
     * Database
     * 
     * Database plugin for TurtlePHP.
     * 
     * @author  Oliver Nassar <onassar@gmail.com>
     * @abstract
     */
    abstract class Database
    {
        /**
         * _configPath
         *
         * @access  protected
         * @var     string (default: 'config.default.inc.php')
         * @static
         */
        protected static $_configPath = 'config.default.inc.php';

        /**
         * _connected
         *
         * @access  protected
         * @var     bool (default: false)
         * @static
         */
        protected static $_connected = false;

        /**
         * _initiated
         *
         * @access  protected
         * @var     bool (default: false)
         * @static
         */
        protected static $_initiated = false;

        /**
         * _checkConfigPluginDependency
         * 
         * @throws  \Exception
         * @access  protected
         * @static
         * @return  bool
         */
        protected static function _checkConfigPluginDependency(): bool
        {
            if (class_exists('\\Plugin\\Config') === true) {
                return true;
            }
            $link = 'https://github.com/onassar/TurtlePHP-ConfigPlugin';
            $msg = '*\Plugin\Config* class required. Please see ' . ($link);
            throw new \Exception($msg);
        }

        /**
         * _checkDependencies
         * 
         * @access  protected
         * @static
         * @return  void
         */
        protected static function _checkDependencies(): void
        {
            static::_checkConfigPluginDependency();
            static::_checkMySQLConnectionDependency();
            static::_checkMySQLQueryDependency();
        }

        /**
         * _checkMySQLConnectionDependency
         * 
         * @throws  \Exception
         * @access  protected
         * @static
         * @return  bool
         */
        protected static function _checkMySQLConnectionDependency(): bool
        {
            if (class_exists('\\MySQLConnection') === true) {
                return true;
            }
            $link = 'https://github.com/onassar/PHP-MySQL';
            $msg = '*\MySQLConnection* class required. Please see ' . ($link);
            throw new \Exception($msg);
        }

        /**
         * _checkMySQLQueryDependency
         * 
         * @throws  \Exception
         * @access  protected
         * @static
         * @return  bool
         */
        protected static function _checkMySQLQueryDependency(): bool
        {
            if (class_exists('\\MySQLQuery') === true) {
                return true;
            }
            $link = 'https://github.com/onassar/PHP-MySQL';
            $msg = '*\MySQLQuery* class required. Please see ' . ($link);
            throw new \Exception($msg);
        }

        /**
         * _getConfigData
         * 
         * @access  protected
         * @static
         * @return  array
         */
        protected static function _getConfigData(): array
        {
            $key = 'TurtlePHP-DatabasePlugin';
            $configData = \Plugin\Config::retrieve($key);
            return $configData;
        }

        /**
         * _getMySQLConnectionOptions
         * 
         * @access  protected
         * @static
         * @return  array
         */
        protected static function _getMySQLConnectionOptions(): array
        {
            $configData = static::_getConfigData();
            $host = $configData['host'];
            $port = $configData['port'];
            $database = $configData['database'];
            $username = $configData['username'];
            $password = $configData['users'][$username];
            $args = array('host', 'port', 'database', 'username', 'password');
            $options = compact(... $args);
            return $options;
        }

        /**
         * _initializeConnection
         * 
         * @access  protected
         * @static
         * @return  void
         */
        protected static function _initializeConnection(): void
        {
            $options = static::_getMySQLConnectionOptions();
            $configData = static::_getConfigData();
            $benchmark = $configData['benchmark'];
            \MySQLConnection::init($options, $benchmark);
        }

        /**
         * _loadConfigPath
         * 
         * @access  protected
         * @static
         * @return  void
         */
        protected static function _loadConfigPath(): void
        {
            $path = static::$_configPath;
            require_once $path;
        }

        /**
         * _runInitialStatements
         * 
         * @access  protected
         * @static
         * @return  void
         */
        protected static function _runInitialStatements(): void
        {
            $configData = static::_getConfigData();
            $initialStatements = $configData['initialStatements'];
            foreach ($initialStatements as $initialStatement) {
                new \MySQLQuery($initialStatement);
            }
        }

        /**
         * _setConnected
         * 
         * @access  protected
         * @static
         * @return  void
         */
        protected static function _setConnected(): void
        {
            static::$_connected = true;
        }

        /**
         * _setInitiated
         * 
         * @access  protected
         * @static
         * @return  void
         */
        protected static function _setInitiated(): void
        {
            static::$_initiated = true;
        }

        /**
         * _setTimezone
         * 
         * @access  protected
         * @static
         * @return  void
         */
        protected static function _setTimezone(): void
        {
            $configData = static::_getConfigData();
            $timezone = $configData['timezone'];
            $statement = 'SET time_zone = `' . ($timezone) . '`';
            new \MySQLQuery($statement);
        }

        /**
         * connect
         * 
         * @access  public
         * @static
         * @return  bool
         */
        public static function connect(): bool
        {
            if (static::$_connected === true) {
                return false;
            }
            static::_setConnected();
            static::_initializeConnection();
            static::_setTimezone();
            static::_runInitialStatements();
            return true;
        }

        /**
         * init
         * 
         * @access  public
         * @static
         * @return  bool
         */
        public static function init(): bool
        {
            if (static::$_initiated === true) {
                return false;
            }
            static::_setInitiated();
            static::_checkDependencies();
            static::_loadConfigPath();
            return true;
        }

        /**
         * setConfigPath
         * 
         * @access  public
         * @param   string $configPath
         * @return  bool
         */
        public static function setConfigPath(string $configPath): bool
        {
            if (is_file($configPath) === false) {
                return false;
            }
            static::$_configPath = $configPath;
            return true;
        }
    }

    // Config path loading
    $info = pathinfo(__DIR__);
    $parent = ($info['dirname']) . '/' . ($info['basename']);
    $configPath = ($parent) . '/config.inc.php';
    Database::setConfigPath($configPath);
