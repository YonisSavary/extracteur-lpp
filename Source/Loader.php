<?php 

namespace Source;

spl_autoload_register(function($class){
    $class = "./". str_replace("\\", "/", $class) . ".php";
    if (is_file($class))
        require_once $class;
});