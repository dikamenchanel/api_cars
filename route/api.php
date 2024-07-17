<?php

use Core\Request;
use Core\Router;
use Controllers\CarController;
 


Router::get('/', [CarController::class, 'index']);
Router::get('/cars', [CarController::class, 'getAllCars']);
Router::get('/cars/filter', [CarController::class, 'getCarsFilter']);
Router::get('/cars/{id}', [CarController::class, 'getCarById']);


$request = new Request();
Router::dispatch($request);
