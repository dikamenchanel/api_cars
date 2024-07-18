<?php

use Core\Router;
use Controllers\CarController;
 


Router::get('/', [CarController::class, 'index']);
Router::get('/cars', [CarController::class, 'getAllCars']);
Router::get('/cars/filter', [CarController::class, 'getCarsFilter']);
Router::get('/cars/{id}', [CarController::class, 'getCarById']);
Router::post('/cars/add', [CarController::class, 'createCar']);
Router::post('/cars/edit/{id}', [CarController::class, 'updateCar']);
Router::delete('/cars/del/{id}', [CarController::class, 'deleteCar']);


