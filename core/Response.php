<?php

namespace Core;

class Response
{
      
      
      /**
       * Добавляет заголовки CORS для разрешения запросов с указанных доменов.
       */
      private static function addCorsHeaders()
      {
            header('Access-Control-Allow-Origin: *'); 
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
      }
      
      /**
       * Отправляет JSON-ответ.
       *
       * @param mixed $data Данные для отправки в формате JSON.
       * @param int $status HTTP статус ответа (по умолчанию 200).
       */
      public static function json($data, $status = 200)
      {
            self::addCorsHeaders();
            http_response_code($status);
            header('Content-Type: application/json');
            echo json_encode($data);
      }
     
      
      /**
       * Отправляет HTML-ответ.
       *
       * @param string $content Содержимое HTML.
       * @param int $status HTTP статус ответа (по умолчанию 200).
       */
      public static function html($content, $status = 200)
      {
            self::addCorsHeaders();
            http_response_code($status);
            header('Content-Type: text/html');
            echo $content;
      }
      
      /**
       * Отправляет текстовый ответ.
       *
       * @param string $content Содержимое текста.
       * @param int $status HTTP статус ответа (по умолчанию 200).
       */
      public static function text($content, $status = 200)
      {
            self::addCorsHeaders();
            http_response_code($status);
            header('Content-Type: text/plain');
            echo $content;
      }
      
      /**
       * Отправляет ответ с ошибкой.
       *
       * @param string $message Сообщение об ошибке.
       * @param int $status HTTP статус ответа (по умолчанию 500).
       */
      public static function error($message, $status = 500)
      {
            self::addCorsHeaders();
            http_response_code($status);
            header('Content-Type: application/json');
            echo json_encode(['error' => $message]);
      }
}
