<?php

namespace Core;

/**
 * Class Request
 * 
 * Represents an HTTP request object, providing methods to retrieve
 * path, HTTP method, and parameters (query, body, and raw input).
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
       * @var array All parameters parsed from the request (query, body, and raw input).
       */
      private $params;
      
      /**
       * @var string The raw input of the request body.
       */
      private $rawInput;
      
      /**
       * Request constructor.
       * Initializes the request object by parsing the URI, method, and parameters
       * from the PHP environment. It also automatically sanitizes and validates
       * parameters to prevent XSS attacks.
       */
      public function __construct()
      {
            $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
            $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
            $this->params = $this->parseParams();
            $this->sanitizeAndValidateParams();
      }
      
      /**
       * Parses all parameters from the request (query, body, and raw input).
       *
       * @return array The parsed parameters.
       */
      private function parseParams()
      {
            $params = [];
            
            // Parse query parameters
            if (!empty($_SERVER['QUERY_STRING'])) {
                  parse_str($_SERVER['QUERY_STRING'], $queryParams);
                  $params = array_merge($params, $queryParams);
            }
            
            // Parse body parameters
            $this->rawInput = file_get_contents('php://input');
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            
            if ($contentType === 'application/json') {
                  $bodyParams = json_decode($this->rawInput, true);
                  if (json_last_error() === JSON_ERROR_NONE) {
                        $params = array_merge($params, $bodyParams);
                  }
            } elseif ($contentType === 'application/x-www-form-urlencoded') {
                  parse_str($this->rawInput, $bodyParams);
                  $params = array_merge($params, $bodyParams);
            } elseif (strpos($contentType, 'multipart/form-data') === 0) {
                  $params = array_merge($params, $_POST);
            }
            
            return $params;
      }
      
      /**
       * Sanitizes a string to prevent XSS attacks.
       *
       * @param string $input The string to sanitize.
       * @return string The sanitized string.
       */
      private function sanitizeString(string $input)
      {
            return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
      }
      
      /**
       * Validates and sanitizes all parameters to prevent XSS attacks.
       */
      private function sanitizeAndValidateParams()
      {
            foreach ($this->params as $key => $value) {
                  if (is_string($value)) {
                        $this->params[$key] = $this->sanitizeString($value);
                  }
                  // Additional validation logic can be added here for specific types or formats
            }
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
       * Retrieves all parameters from the request.
       *
       * @return array The parameters.
       */
      public function getParams()
      {
            return $this->params;
      }
      
      /**
       * Retrieves a specific parameter from the request.
       * If the parameter is not found, returns the default value.
       *
       * @param string $key The parameter key.
       * @param mixed $default The default value if parameter is not found.
       * @return mixed The value of the parameter.
       */
      public function getParam(string $key, $default = null)
      {
            return $this->params[$key] ?? $default;
      }
}
