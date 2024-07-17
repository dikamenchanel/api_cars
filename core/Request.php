<?php

namespace Core;

/**
 * Class Request
 * 
 * Represents an HTTP request object, providing methods to retrieve
 * path, HTTP method, query parameters, and body parameters.
 */
class Request
{
      /**
       * @var string The path of the request URI.
       */
      private $path;
      
      /**
       * @var string The HTTP method of the request (e.g., GET, POST, PUT, DELETE).
       */
      private $method;
      
      /**
       * @var array The query parameters parsed from the request URI.
       */
      private $queryParams = [];
      
      /**
       * @var array The body parameters parsed from the request body (JSON format).
       */
      private $bodyParams = [];
      
      /**
       * Request constructor.
       * Initializes the request object by parsing the URI, method, query parameters,
       * and body parameters from the PHP environment.
       */
      public function __construct()
      {
            $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
            $this->method = $_SERVER['REQUEST_METHOD'];
            $this->queryParams = $this->parseQueryParams();
            $this->bodyParams = $this->parseBodyParams();
      }
      
      /**
       * Parses the query parameters from the request URI.
       *
       * @return array The parsed query parameters.
       */
      private function parseQueryParams()
      {
            $queryParams = [];
            if (isset($_SERVER['QUERY_STRING'])) {
                  parse_str($_SERVER['QUERY_STRING'], $queryParams);
            }
            return $queryParams;
      }
      
      /**
       * Parses the body parameters from the request body (assumes JSON format).
       *
       * @return array The parsed body parameters.
       */
      private function parseBodyParams()
      {
            $bodyParams = [];
            $input = file_get_contents('php://input');
            if ($input) {
                  $bodyParams = json_decode($input, true);
            }
            return $bodyParams;
      }
      
      /**
       * Retrieves the path of the request URI.
       *
       * @return string The request path.
       */
      public function getPath()
      {
            return $this->path;
      }
      
      /**
       * Retrieves the HTTP method of the request.
       *
       * @return string The HTTP method (GET, POST, PUT, DELETE, etc.).
       */
      public function getMethod()
      {
            return $this->method;
      }
      
      /**
       * Retrieves the query parameters from the request URI.
       *
       * @return array The query parameters.
       */
      public function getQueryParams()
      {
            return $this->queryParams;
      }
      
      /**
       * Retrieves the body parameters from the request body.
       *
       * @return array The body parameters.
       */
      public function getBodyParams()
      {
            return $this->bodyParams;
      }
      
      /**
       * Retrieves a specific parameter from either query or body parameters.
       * If the parameter is not found, returns the default value.
       *
       * @param string $key The parameter key.
       * @param mixed $default The default value if parameter is not found.
       * @return mixed The value of the parameter.
       */
      public function getParam($key, $default = null)
      {
            if (isset($this->queryParams[$key])) {
                  return $this->queryParams[$key];
            } elseif (isset($this->bodyParams[$key])) {
                  return $this->bodyParams[$key];
            }
            return $default;
      }
}
