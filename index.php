<?php
require_once("configuration.php");
require_once("includes/Functions.php");


class InputFunction
{

public  $FunctionName;
public  $inputs=array();
}


if (!isset($_SERVER['PHP_AUTH_USER'])) {
    header('WWW-Authenticate: Basic realm="My Realm"');
    header('HTTP/1.0 401 Unauthorized');
    echo '';
    exit;
} else {
    if($_SERVER['PHP_AUTH_USER']==AUSER&&$_SERVER['PHP_AUTH_PW']==APASS)
    {
              //GET JSON DATA
              $data = json_decode(file_get_contents('php://input'));
              if($data)
              {
                $data->FunctionName;
                call_user_func($data->FunctionName,$data->inputs);
              }
    }
}

?>
