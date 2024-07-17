<?php

namespace Core;

class Response
{
      /**
       * Отправляет JSON-ответ.
       *
       * @param mixed $data Данные для отправки в формате JSON.
       * @param int $status HTTP статус ответа (по умолчанию 200).
       */
      public static function json($data, $status = 200)
      {
            http_response_code($status);
            header('Content-Type: application/json');
            echo json_encode($data);
      }
} 
