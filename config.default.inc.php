<?php

    /**
     * Plugin Config Data
     * 
     */
    $pluginConfigData = array(
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
     * Storage
     * 
     */
    $key = 'TurtlePHP-DatabasePlugin';
    TurtlePHP\Plugin\Config::set($key, $pluginConfigData);
