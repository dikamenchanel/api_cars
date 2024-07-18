<?php

namespace Core;

use PDO;

class Database
{
      
      private $pdo;
      
      public function __construct()
      {
            try {
                  $this->pdo = new PDO("mysql:host=".MYSQL_HOST.";dbname=".MYSQL_BASE, MYSQL_USER, MYSQL_PASS);
                  $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                  die("Database connection failed: " . $e->getMessage());
            }
      }
      
      /**
       * 
       * method processes requests and prepares sql
       * returns response MYSQL
       * @param $sql - string; $params - array;
       * 
       */
      public function query($sql, $params = [])
      {
            
            try {
                  $stmt = $this->pdo->prepare($sql);
                  foreach ($params as $paramName => $paramValue) {
                        if (is_int($paramValue)) {
                              $paramType = PDO::PARAM_INT;
                        } elseif (is_bool($paramValue)) {
                              $paramType = PDO::PARAM_BOOL;
                        } elseif (is_null($paramValue)) {
                              $paramType = PDO::PARAM_NULL;
                        } else {
                              $paramType = PDO::PARAM_STR;
                        }
                        $stmt->bindValue($paramName, $paramValue, $paramType);
                  }

                  $stmt->execute();
                  return $stmt;
                  
            } catch (PDOException $e) {
                  die("Query failed: " . $e->getMessage());
            }
      }
      
      
      /**
       * 
       * method select data with Database in tables 
       * return one @array
       * @param $sql - string; $params - array; $type - int
       * 
       */
      public function selectOne($sql, $params = [], $type = PDO::FETCH_ASSOC)
      {
            $type = $this->isType($type);
            $stmt = $this->query($sql, $params);
            return $stmt->fetch($type);
      }
      
      /**
       * 
       * method select data with Database in tables 
       * return @array
       * @param $sql - string; $params - array; $type - int
       * 
       */
      public function selectMany($sql, $params = [], $type = PDO::FETCH_ASSOC)
      {
            $type = $this->isType($type);
            $stmt = $this->query($sql, $params);
            return $stmt->fetchAll($type);
      }
      
      /**
       * 
       * method insert data with Database in tables
       * return `id` last insert
       * @param $table - string; $data - array
       * 
       */
      public function insert($table, $data)
      {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));
            
            $sql = "INSERT INTO $table ($columns) VALUES ($values)";
            $this->query($sql, $data);
            return $this->pdo->lastInsertId();
      }
      
      /**
       * 
       * method update data with Database in tables
       * @param $table - string; $data, $where - arrayes
       * 
       */
      public function update($table, $data, $where)
      {
            $set = [];
            $newData = [];
            foreach ($data as $key => $value) {
                  $set[] = "$key = :$key";
                  $newData[] = $value;
            }
            
            $set = implode(", ", $set);
            $sql = "UPDATE $table SET $set WHERE $where";
            
            $res = $this->query($sql, $data);
            return $res->rowCount();
            
      }
      
      /**
       * 
       * method delete data with Database in tables
       * @param $table - string, $where - array
       * 
       */
      public function delete($table, $where)
      {
            $sql = "DELETE FROM $table WHERE $where";
            $res = $this->query($sql);
            return $res->rowCount();
      }
     
      
      private function isType($type)
      {
            switch ($type)
            {
                  case 0:
                        return $t = PDO::FETCH_COLUMN;
                        break;
                  case 1:
                        return $t = PDO::FETCH_OBJ;
                        break;
                  case 2:
                        return $t = PDO::FETCH_ASSOC;
                        break;
                  case 3:
                        return $t = PDO::FETCH_NUM;
                        break;
                  case 4:
                        return $t = PDO::FETCH_BOTH;
                        break;
            }
      }
}
