<?php
require_once("Functions.php");

class InputFunction
{
public  $key;
public  $FunctionName;
public  $inputs=array();
}
//GET JSON DATA
$data = json_decode(file_get_contents('php://input'));
if($data)
{
  //DATA IS NOT NULL
  if(ValidateKEY($data->key))
  {
  $data->FunctionName;
  call_user_func($data->FunctionName,$data->inputs,$data->key);
  }
}

function ValidateKEY($key)
{
  //VALIDATION Function
if($key>=-1)
{
  return true;
}
}

?>
