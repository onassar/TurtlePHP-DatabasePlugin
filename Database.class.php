<?php

    // namespace
    namespace Plugin;

    // dependency check
    if (class_exists('\\Plugin\\Config') === false) {
        throw new \Exception(
            '*Config* class required. Please see ' .
            'https://github.com/onassar/TurtlePHP-ConfigPlugin'
        );
    }

    // dependency check
    if (class_exists('\\MySQLConnection') === false) {
        throw new \Exception(
            '*MySQLConnection* class required. Please see ' .
            'https://github.com/onassar/PHP-MySQL'
        );
    }

    // dependency check
    if (class_exists('\\MySQLQuery') === false) {
        throw new \Exception(
            '*MySQLQuery* class required. Please see ' .
            'https://github.com/onassar/PHP-MySQL'
        );
    }

    /**
     * Database
     * 
     * Database plugin for TurtlePHP
     * 
     * @author  Oliver Nassar <onassar@gmail.com>
     * @abstract
     */
    abstract class Database
    {
        /**
         * _configPath
         *
         * @var     string
         * @access  protected
         * @static
         */
        protected static $_configPath = 'config.default.inc.php';

        /**
         * _connected
         *
         * @var     boolean
         * @access  protected
         * @static
         */
        protected static $_connected = false;

        /**
         * _getConfig
         * 
         * @access  protected
         * @static
         * @return  array
         */
        protected static function _getConfig()
        {
            return Config::retrieve('TurtlePHP-DatabasePlugin');
        }

        /**
         * _initializeConnection
         * 
         * @access  protected
         * @static
         * @return  void
         */
        protected static function _initializeConnection()
        {
            $config = self::_getConfig();
            \MySQLConnection::init(array(
                'host' => $config['host'],
                'port' => $config['port'],
                'database' => $config['database'],
                'username' => $config['username'],
                'password' => $config['password']
            ), $config['benchmark']);
        }

        /**
         * _setEncoding
         * 
         * @access  protected
         * @static
         * @return  void
         */
        protected static function _setEncoding()
        {
            $config = self::_getConfig();
            $encoding = $config['encoding'];
            $statement = 'SET names ' . ($encoding);
            new \MySQLQuery($statement);
        }

        /**
         * _setTimezone
         * 
         * @access  protected
         * @static
         * @return  void
         */
        protected static function _setTimezone()
        {
            $config = self::_getConfig();
            $timezone = $config['timezone'];
            $statement = 'SET time_zone = `' . ($timezone) . '`';
            new \MySQLQuery($statement);
        }

        /**
         * connect
         * 
         * @access  public
         * @static
         * @return  void
         */
        public static function connect()
        {
            if (self::$_connected === false) {
                self::$_connected = true;
                require_once self::$_configPath;
                self::_initializeConnection();
                self::_setTimezone();
                self::_setEncoding();
            }
        }

        /**
         * setConfigPath
         * 
         * @access  public
         * @param   string $path
         * @return  void
         */
        public static function setConfigPath($path)
        {
            self::$_configPath = $path;
        }
    }

    // Config
    $info = pathinfo(__DIR__);
    $parent = ($info['dirname']) . '/' . ($info['basename']);
    $configPath = ($parent) . '/config.inc.php';
    if (is_file($configPath) === true) {
        Database::setConfigPath($configPath);
    }
