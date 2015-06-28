<?php
class InputFunction
{
public  $key;
public  $FunctionName;
public  $inputs=array();
}
$data = json_decode(file_get_contents('php://input'));
if($data)
{
  if(ValidateKEY($data->key))
  {
  $data->FunctionName;
  call_user_func($data->FunctionName,$data->inputs);
  }
}
function ValidateKEY($key)
{
if($key>=-1)
{
  return true;
}
}

//***********Functions Start here //

function Register($a)
{
$user= $a[0];
include("members.php");
$newMember=new member($user);
}

 ?>
