<?php

namespace Controllers;

use Core\Response;
use Core\Request;
use Models\CarsModel;

/**
 * Class CarController
 * @package Controllers
 *
 * This controller handles car-related operations such as fetching all cars,
 * fetching a car by ID, and filtering cars based on various parameters.
 */
class CarController
{
      /**
       * @var CarsModel
       */
      private $carsModel;
      
      /**
       * CarController constructor.
       * Initializes the CarsModel instance.
       */
      public function __construct()
      {
            $this->carsModel = new CarsModel();
      }
      
      /**
       * Basic index method to check if the API is working.
       *
       * @return \Core\Response
       */
      public function index()
      {
            return Response::json(["status" => "success", "message" => "Work My Rest FULL Api", "data" => []]);
      }
      
      /**
       * Fetches all cars from the database.
       *
       * @return void
       */
      public function getAllCars()
      {
            $result = $this->carsModel->getAllCars();
            Response::json(["status" => "success", "message" => "", "data" => $result]);
      }
      
      /**
       * Fetches a car by its ID.
       *
       * @param Request $request
       * @param int $id
       * @return \Core\Response
       */
      public function getCarById(Request $request, $id)
      {
            $result = $this->carsModel->imagesToArray($this->carsModel->getCartById($id));
            if ($result) {
                  return Response::json(["status" => "success", "message" => "Work My Rest FULL Api", "data" => $result]);
            }
            
            return Response::json(["status" => "success", "message" => "This id not found in Base", "data" => '']);
      }
      
      /**
       * Fetches cars based on filter parameters.
       *
       * @param Request $request
       * @return \Core\Response
       */
      public function getCarsFilter($request)
      {
            $result = $request->getQueryParams();
            
            $mark = $result['mark'] ?? null;
            $fromPrice = $result['fromPrice'] ?? null;
            $toPrice = $result['toPrice'] ?? null;
            $fromYear = $result['fromYear'] ?? null;
            $toYear = $result['toYear'] ?? null;
            
            $filterData = $this->carsModel->getCarsByFilters($mark, $fromPrice, $toPrice, $fromYear, $toYear);
            
            if (empty($result)) {
                  $data = [
                        'status' => 'error',
                        'message' => 'No parameters used. Use at least one set of parameters: fromPrice/toPrice or fromYear/toYear, and optionally mark.',
                        'data' => [],
                  ];
                  $status = 400;
            } else if (empty($filterData)) {
                  $data = [
                        'status' => 'error',
                        'message' => 'No cars found for the given parameters.',
                        'data' => [],
                  ];
                  $status = 404;
            } else {
                  $data = [
                        'status' => 'success',
                        'message' => 'Request completed successfully',
                        'data' => $filterData,
                  ];
                  $status = 200;
            }
            
            return Response::json($data, $status);
      }
}
