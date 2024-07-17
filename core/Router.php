<?php

namespace Core;

use Core\Response;

/**
 * Class Router
 *
 * Simple router implementation for handling HTTP request routing and dispatching
 * based on specified routes.
 */
class Router
{
      /**
       * @var array Stores registered routes with HTTP method, path pattern, and handler.
       */
      private static $routes = [];
      
      /**
       * Registers a GET route with the specified path and handler.
       *
       * @param string $path The route path pattern.
       * @param array $handler The handler for the route (class and method).
       */
      public static function get($path, $handler)
      {
            self::addRoute('GET', $path, $handler);
      }
      
      /**
       * Registers a POST route with the specified path and handler.
       *
       * @param string $path The route path pattern.
       * @param array $handler The handler for the route (class and method).
       */
      public static function post($path, $handler)
      {
            self::addRoute('POST', $path, $handler);
      }
      
      /**
       * Registers a PUT route with the specified path and handler.
       *
       * @param string $path The route path pattern.
       * @param array $handler The handler for the route (class and method).
       */
      public static function put($path, $handler)
      {
            self::addRoute('PUT', $path, $handler);
      }
      
      /**
       * Registers a DELETE route with the specified path and handler.
       *
       * @param string $path The route path pattern.
       * @param array $handler The handler for the route (class and method).
       */
      public static function delete($path, $handler)
      {
            self::addRoute('DELETE', $path, $handler);
      }
      
      /**
       * Adds a route to the internal routes array.
       *
       * @param string $method The HTTP method of the route.
       * @param string $path The route path pattern.
       * @param array $handler The handler for the route (class and method).
       */
      private static function addRoute($method, $path, $handler)
      {
            self::$routes[] = [
                  'method' => $method,
                  'path' => $path,
                  'handler' => $handler
            ];
      }
      
      /**
       * Dispatches the HTTP request to the appropriate handler based on registered routes.
       *
       * @param Request $request The HTTP request object.
       */
      public static function dispatch(Request $request)
      {
            $requestMethod = $request->getMethod();
            $requestUri = $request->getPath();
            
            foreach (self::$routes as $route) {
                  if ($route['method'] === strtoupper($requestMethod) && preg_match(self::convertPathToRegex($route['path']), $requestUri, $matches)) {
                        array_shift($matches);
                        return self::executeHandler($route['handler'], $request, $matches);
                  }
            }
            
            Response::json(['status' => 'error', 'message' => 'URL Not Found'], 404);
      }
      
      /**
       * Converts a route path pattern to a regex pattern for matching.
       *
       * @param string $path The route path pattern.
       * @return string The regex pattern for matching the route path.
       */
      private static function convertPathToRegex($path)
      {
            return "#^" . preg_replace('/{([^}]+)}/', '([^/]+)', $path) . "$#";
      }
      
      /**
       * Executes the handler for the matched route.
       *
       * @param array $handler The handler for the route (class and method).
       * @param Request $request The HTTP request object.
       * @param array $params The parameters extracted from the route path.
       * @return mixed The result of the handler execution.
       */
      private static function executeHandler($handler, Request $request, $params)
      {
            list($class, $method) = $handler;
            if (class_exists($class) && method_exists($class, $method)) {
                  $controller = new $class();
                  
                  return call_user_func_array([$controller, $method], array_merge([$request], $params));
            }
            
            Response::json(['status' => 'error', 'message' => 'Handler not found'], 404);
      }
}
