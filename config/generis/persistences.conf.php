<?php
/**
 * Default config header created during install
 */

return new common_persistence_Manager(array(
    'persistences' => array(
        'cache' => array(
            'driver' => 'phpfile'
        ),
        'default' => array(
            'driver' => 'pdo_mysql',
            'host' => 'localhost',
            'dbname' => 'tao_db',
            'user' => 'root',
            'password' => 'seagate8000'
        ),
        'serviceState' => array(
            'driver' => 'phpfile'
        ),
        'maintenance' => array(
            'driver' => 'phpfile'
        )
    )
));
