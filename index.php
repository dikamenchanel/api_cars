<?php


// Включаем отчет об ошибках
error_reporting(E_ALL);

// Включаем отображение ошибок
ini_set('display_errors', 'On');

// Включаем отображение ошибок при старте
ini_set('display_startup_errors', 'On');


 require_once 'config/php.ini.php';
 
 require ROOT_PATH . '/core/autoload.php';


 require ROOT_PATH . '/route/api.php';

