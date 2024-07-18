<?php

namespace Core;

use Core\Response;

/**
 * Class Router
 *
 * Improved router implementation with security and performance enhancements.
 */
class Router
{
      /**
       * @var array Stores registered routes with HTTP method, path pattern, and handler.
       */
      private static $routes = [];
      
      /**
       * @var array Cached compiled routes for fast lookup.
       */
      private static $cachedRoutes = [];
      
      /**
       * Registers a route with the specified HTTP method, path, and handler.
       *
       * @param string $method The HTTP method of the route.
       * @param string $path The route path pattern.
       * @param array $handler The handler for the route (class and method).
       */
      public static function addRoute(string $method, string $path, array $handler)
      {
            self::$routes[$method][$path] = $handler;
            self::$cachedRoutes = []; // Invalidate cache
      }
      
      /**
       * Registers a GET route with the specified path and handler.
       *
       * @param string $path The route path pattern.
       * @param array $handler The handler for the route (class and method).
       */
      public static function get(string $path, array $handler)
      {
            self::addRoute('GET', $path, $handler);
      }
      
      /**
       * Registers a POST route with the specified path and handler.
       *
       * @param string $path The route path pattern.
       * @param array $handler The handler for the route (class and method).
       */
      public static function post(string $path, array $handler)
      {
            self::addRoute('POST', $path, $handler);
      }
      
      /**
       * Registers a PUT route with the specified path and handler.
       *
       * @param string $path The route path pattern.
       * @param array $handler The handler for the route (class and method).
       */
      public static function put(string $path, array $handler)
      {
            self::addRoute('PUT', $path, $handler);
      }
      
      /**
       * Registers a DELETE route with the specified path and handler.
       *
       * @param string $path The route path pattern.
       * @param array $handler The handler for the route (class and method).
       */
      public static function delete(string $path, array $handler)
      {
            self::addRoute('DELETE', $path, $handler);
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
            
            if (!isset(self::$routes[$requestMethod])) {
                  Response::json(['status' => 'error', 'message' => 'Method Not Allowed'], 405);
                  return;
            }
            
            $routeHandler = self::findRouteHandler($requestMethod, $requestUri);
            if ($routeHandler) {
                  [$handler, $params] = $routeHandler;
                  self::executeHandler($handler, $request, $params);
            } else {
                  Response::json(['status' => 'error', 'message' => 'URL Not Found'], 404);
            }
      }
      
      /**
       * Finds the route handler for the given method and URI.
       *
       * @param string $method The HTTP method.
       * @param string $uri The request URI.
       * @return array|null The route handler and parameters, or null if not found.
       */
      private static function findRouteHandler(string $method, string $uri)
      {
            if (isset(self::$cachedRoutes[$method][$uri])) {
                  return self::$cachedRoutes[$method][$uri];
            }
            
            foreach (self::$routes[$method] as $path => $handler) {
                  if (preg_match(self::convertPathToRegex($path), $uri, $matches)) {
                        array_shift($matches);
                        self::$cachedRoutes[$method][$uri] = [$handler, $matches];
                        return [$handler, $matches];
                  }
            }
            
            return null;
      }
      
      /**
       * Converts a route path pattern to a regex pattern for matching.
       *
       * @param string $path The route path pattern.
       * @return string The regex pattern for matching the route path.
       */
      private static function convertPathToRegex(string $path)
      {
            return "#^" . preg_replace('/{([^}]+)}/', '([^/]+)', $path) . "$#";
      }
      
      /**
       * Executes the handler for the matched route.
       *
       * @param array $handler The handler for the route (class and method).
       * @param Request $request The HTTP request object.
       * @param array $params The parameters extracted from the route path.
       */
      private static function executeHandler(array $handler, Request $request, array $params)
      {
            [$class, $method] = $handler;
            if (class_exists($class) && method_exists($class, $method)) {
                  $controller = new $class();
                  call_user_func_array([$controller, $method], array_merge([$request], $params));
            } else {
                  Response::json(['status' => 'error', 'message' => 'Handler not found'], 404);
            }
      }
}
