<?php

return [
      'autoload' => [
            'Conf\\' => ROOT_PATH .'/conf/',
            'Core\\' => ROOT_PATH .'/core/',
            'Models\\' =>  ROOT_PATH .'/models/',
            // 'View\\' => ROOT_PATH .'/view/',
            'Controllers\\' => ROOT_PATH .'/controllers/',
      ],
      'database' => [
            'host' => 'localhost',
            'username' => 'laravel_usr',
            'password' => '87654321',
            'database' => 'cars',
      ],
];

