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
        'users' => array(
            'app' => 'apples'
        ),
        'database' => 'mysql',
        'initialStatements' => array(
            'SET names utf8mb4',
            'SET collation_connection = utf8mb4_unicode_ci'
        ),
        'timezone' => 'ETC/UTC',
        'benchmark' => true
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
