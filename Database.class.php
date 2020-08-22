<?php

    // Namespace overhead
    namespace TurtlePHP\Plugin;

    /**
     * Database
     * 
     * Database plugin for TurtlePHP.
     * 
     * @author  Oliver Nassar <onassar@gmail.com>
     * @abstract
     * @extends Base
     */
    abstract class Database extends Base
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
            parent::init();
            return true;
        }
    }

    // Config path loading
    $info = pathinfo(__DIR__);
    $parent = ($info['dirname']) . '/' . ($info['basename']);
    $configPath = ($parent) . '/config.inc.php';
    \TurtlePHP\Plugin\Database::setConfigPath($configPath);
