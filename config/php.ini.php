<?php
 
 define("ROOT_PATH", __DIR__."/..");
 
 $settings = require ROOT_PATH . "/config/settings.php";
 
 define('MYSQL_HOST', $settings['database']['host']);
 define('MYSQL_BASE', $settings['database']['database']);
 define('MYSQL_USER', $settings['database']['username']);
 define('MYSQL_PASS', $settings['database']['password']);
