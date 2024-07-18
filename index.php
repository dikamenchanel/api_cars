<?php


// Включаем отчет об ошибках
error_reporting(E_ALL);

// Включаем отображение ошибок
ini_set('display_errors', 'On');

// Включаем отображение ошибок при старте
ini_set('display_startup_errors', 'On');

 // Подключаем конфиги сайте
 require_once 'config/php.ini.php';
 
 // Подключаем функцию spl_autoload_functions для подгрузки всех Namespace
 require ROOT_PATH . '/core/autoload.php';

 // Подключаем routes 
 require ROOT_PATH . '/route/api.php';

 
 use Core\Request;
 use Core\Router;
 
 //Инициализируем класс Request чтобы передать его в Router
 $request = new Request();
 
 // Запускаем Router
 Router::dispatch($request);
 
 
