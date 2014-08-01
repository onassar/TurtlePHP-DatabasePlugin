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
     * Memcached database plugin for TurtlePHP
     * 
     * @author   Oliver Nassar <onassar@gmail.com>
     * @abstract
     */
    abstract class Database
    {
        /**
         * _configPath
         *
         * @var    string
         * @access protected
         * @static
         */
        protected static $_configPath = 'config.inc.php';

        /**
         * _connected
         *
         * @var    boolean
         * @access protected
         * @static
         */
        protected static $_connected = false;

        /**
         * connect
         * 
         * @access public
         * @static
         * @return void
         */
        public static function connect()
        {
            if (is_null(self::$_connected) === false) {
                self::$_connected = true;
                require_once self::$_configPath;
                $config = \Plugin\Config::retrieve();
                $config = $config['TurtlePHP-DatabasePlugin'];
                \MySQLConnection::init(array(
                    'host' => $config['host'],
                    'port' => $config['port'],
                    'username' => $config['username'],
                    'password' => $config['password']
                ));
                (new \MySQLQuery('USE `'.  ($config['name']) . '`'));
                (new \MySQLQuery(
                    'SET time_zone = \'' . ($config['timezone']) . '\''
                ));
                (new \MySQLQuery('SET names ' . ($config['encoding'])));
            }
        }

        /**
         * setConfigPath
         * 
         * @access public
         * @param  string $path
         * @return void
         */
        public static function setConfigPath($path)
        {
            self::$_configPath = $path;
        }
    }
