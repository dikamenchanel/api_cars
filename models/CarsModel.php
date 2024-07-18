<?php

namespace Models;

use Core\DataBase;

/**
 * Class CarsModel
 *
 * Represents a model for handling car-related database operations.
 */
class CarsModel extends DataBase
{
      /**
       * CarsModel constructor.
       * Initializes the database connection using parent constructor.
       */
      function __construct()
      {
            parent::__construct();
            $this->checkAndCreateTable();
      }
     
      
      /**
       * Checks if the cars table exists and creates it if it doesn't.
       */
      private function checkAndCreateTable()
      {
            try {
                  $sql = "
                  SELECT 1 
                  FROM information_schema.tables 
                  WHERE table_schema = :database_name 
                  AND table_name = :table_name
                  ";
                  
                  $params = [
                        ':database_name' => MYSQL_BASE,
                        ':table_name' => 'cars'
                  ];
                  
                  $stmt = $this->query($sql, $params);
                  
                  if ($stmt->fetchColumn() === false) {
                        $this->createCarsTable();
                  }
            } catch (PDOException $e) {
                  die("Error checking or creating cars table: " . $e->getMessage());
            }
      }
      
      /**
       * Creates the cars table.
       */
      private function createCarsTable()
      {
            try {
                  $sql = "
                  CREATE TABLE cars (
                        id INT AUTO_INCREMENT PRIMARY KEY,
                        url VARCHAR(255) ,
                        brand VARCHAR(100) NOT NULL,
                        model VARCHAR(100) ,
                        year INT,
                        price DECIMAL(10, 2),
                        images TEXT
                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";
                  
                  $this->query($sql);
            } catch (PDOException $e) {
                  die("Error creating cars table: " . $e->getMessage());
            }
      }
      
      
      
      /**
       * Retrieves all cars from the database.
       *
       * @return array Array of cars containing id, brand, model, and year.
       */
      public function getAllCars()
      {
            return $this->selectMany("SELECT id, url, brand, model, year FROM cars");
      }
      
      /**
       * Retrieves a car by its ID from the database.
       *
       * @param int $id The ID of the car to retrieve.
       * @return array|null The car data as an associative array or null if not found.
       */
      public function getCartById($id)
      {
            return $this->selectOne("SELECT * FROM cars WHERE id = :id", ["id" => $id]);
      }
      
      /**
       * Converts images field of the car data to an array of image URLs.
       *
       * @param mixed $data The car data, typically retrieved from the database.
       * @return array The modified car data with images field as an array of URLs.
       */
      public function imagesToArray($data)
      {
            $result = [];
            if (isset($data['images'])) {
                  $data['images'] = explode(',', $data['images']);
                  $result = $data;
            } else if (gettype($data) == 'array|object') {
                  foreach ($data as $key => $car) {
                        if (isset($car['images'])) {
                              $car['images'] = explode(',', $car['images']);
                              $result[$key] = $car;
                        }
                  }
            }
            
            return $result;
      }
      
      /**
       * Retrieves cars from the database based on optional filter parameters.
       *
       * @param string|null $mark Brand of the car to filter by.
       * @param float|null $fromPrice Minimum price of the car.
       * @param float|null $toPrice Maximum price of the car.
       * @param int|null $fromYear Minimum year of manufacture.
       * @param int|null $toYear Maximum year of manufacture.
       * @return array Array of cars matching the filter criteria.
       */
      public function getCarsByFilters($mark = null, $fromPrice = null, $toPrice = null, $fromYear = null, $toYear = null)
      {
            $sql = "SELECT * FROM cars WHERE 1=1";
            $params = [];
            
            if ($mark) {
                  $sql .= " AND brand = :mark";
                  $params[':mark'] = $mark;
            }
            
            if ($fromPrice && $toPrice) {
                  $sql .= " AND price BETWEEN :fromPrice AND :toPrice";
                  $params[':fromPrice'] = $fromPrice;
                  $params[':toPrice'] = $toPrice;
            }
            
            if ($fromYear && $toYear) {
                  $sql .= " AND year BETWEEN :fromYear AND :toYear";
                  $params[':fromYear'] = $fromYear;
                  $params[':toYear'] = $toYear;
            }
            
            return $this->selectMany($sql, $params);
      }
      
      /**
       * Converts images field of the car data to an array of image URLs.
       *
       * @param mixed $data The car data, typically retrieved from the database.
       * @return array The modified car data with images field as an array of URLs.
       */
      public function add($data)
      {            
            return $this->insert('cars', $data);
      }
      
      /**
       * Converts images field of the car data to an array of image URLs.
       *
       * @param mixed $data The car data, typically retrieved from the database.
       * @return array The modified car data with images field as an array of URLs.
       */
      public function edit($data, $id)
      {
            return $this->update('cars', $data, "id = {$id}");
      }
      
      
      /**
       * Converts images field of the car data to an array of image URLs.
       *
       * @param mixed $data The car data, typically retrieved from the database.
       * @return array The modified car data with images field as an array of URLs.
       */
      public function del($id)
      {
            var_dump($id);
            return $this->delete("cars", "id = {$id}");
      }
}
