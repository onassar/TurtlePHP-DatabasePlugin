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
        'encoding' => 'utf8',
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
