<?php

$settings = require ROOT_PATH . "/config/settings.php";


spl_autoload_register(function($class) use ($settings) {
      
      foreach($settings['autoload'] as $prefix => $path)
      {
            if (strpos($class, $prefix) === 0) 
            {
                  $file =  $path . str_replace('\\', '/', substr($class, strlen($prefix))) . '.php';
                  // $fileClass = ROOT_PATH . $path . str_replace('\\', '/', $class) . '.php';
                  
                  if(file_exists($file))
                  {
                        require $file;
                        return;
                  }
            }
      }
});



