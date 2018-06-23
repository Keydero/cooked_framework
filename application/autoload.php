<?php 

spl_autoload_register(function($class) 
{
    $namespaceClass = explode( '\\', $class ); 
    $class =  array_pop( $namespaceClass ); 
    if (strrpos($class, 'Controller') !== false)
    {
        include   "controllers/" .$class . '.class.php';
    }
    elseif (strrpos($class, 'Model') !== false) 
    {
        include   "models/" .$class . '.class.php';
    }
    else 
    {
    include    $class . '.class.php';
  
    }

});

