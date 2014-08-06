<?php

    /**
     * Namespace
     * 
     */
    namespace Plugin\Database;

    /**
     * Config settings
     * 
     */
    $config = array(
        'host' => 'localhost',
        'port' => 3306,
        'username' => 'app',
        'password' => 'apples',
        'database' => 'mysql',
        'encoding' => 'utf8',
        'timezone' => 'ETC\/UTC'
    );

    /**
     * Config storage
     * 
     */

    // Store
    \Plugin\Config::add(
        'TurtlePHP-DatabasePlugin',
        $config
    );
