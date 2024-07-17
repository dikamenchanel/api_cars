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
      private string $path;
      
      /**
       * @var string The HTTP method of the request (e.g., GET, POST, PUT, DELETE).
       */
      private string $method;
      
      /**
       * @var array The query parameters parsed from the request URI.
       */
      private array $queryParams;
      
      /**
       * @var array The body parameters parsed from the request body.
       */
      private array $bodyParams;
      
      /**
       * @var string The raw input of the request body.
       */
      private string $rawInput;
      
      /**
       * Request constructor.
       * Initializes the request object by parsing the URI, method, query parameters,
       * and body parameters from the PHP environment. It also automatically sanitizes
       * and validates parameters to prevent XSS attacks.
       */
      public function __construct()
      {
            $this->path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';
            $this->method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
            $this->queryParams = $this->parseQueryParams();
            $this->rawInput = file_get_contents('php://input');
            $this->bodyParams = $this->parseBodyParams();
            $this->sanitizeAndValidateParams();
      }
      
      /**
       * Parses the query parameters from the request URI.
       *
       * @return array The parsed query parameters.
       */
      private function parseQueryParams(): array
      {
            $queryParams = [];
            if (!empty($_SERVER['QUERY_STRING'])) {
                  parse_str($_SERVER['QUERY_STRING'], $queryParams);
            }
            return $queryParams;
      }
      
      /**
       * Parses the body parameters from the request body based on the content type.
       *
       * @return array The parsed body parameters.
       */
      private function parseBodyParams(): array
      {
            $bodyParams = [];
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            
            if ($contentType === 'application/json') {
                  $bodyParams = json_decode($this->rawInput, true);
                  if (json_last_error() !== JSON_ERROR_NONE) {
                        $bodyParams = [];
                  }
            } elseif ($contentType === 'application/x-www-form-urlencoded') {
                  parse_str($this->rawInput, $bodyParams);
            } elseif (strpos($contentType, 'multipart/form-data') === 0) {
                  $bodyParams = $_POST;
            }
            
            return $bodyParams;
      }
      
      /**
       * Sanitizes a string to prevent XSS attacks.
       *
       * @param string $input The string to sanitize.
       * @return string The sanitized string.
       */
      private function sanitizeString(string $input): string
      {
            return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
      }
      
      /**
       * Validates and sanitizes all query and body parameters to prevent XSS attacks.
       */
      private function sanitizeAndValidateParams()
      {
            foreach ($this->queryParams as $key => $value) {
                  $this->queryParams[$key] = $this->sanitizeString($value);
            }
            
            foreach ($this->bodyParams as $key => $value) {
                  if (is_string($value)) {
                        $this->bodyParams[$key] = $this->sanitizeString($value);
                  }
                  // Additional validation logic can be added here for specific types or formats
            }
      }
      
      /**
       * Retrieves the path of the request URI.
       *
       * @return string The request path.
       */
      public function getPath(): string
      {
            return $this->path;
      }
      
      /**
       * Retrieves the HTTP method of the request.
       *
       * @return string The HTTP method (GET, POST, PUT, DELETE, etc.).
       */
      public function getMethod(): string
      {
            return $this->method;
      }
      
      /**
       * Retrieves the query parameters from the request URI.
       *
       * @return array The query parameters.
       */
      public function getQueryParams(): array
      {
            return $this->queryParams;
      }
      
      /**
       * Retrieves the body parameters from the request body.
       *
       * @return array The body parameters.
       */
      public function getBodyParams(): array
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
      public function getParam(string $key, $default = null)
      {
            return $this->queryParams[$key] ?? $this->bodyParams[$key] ?? $default;
      }
}

