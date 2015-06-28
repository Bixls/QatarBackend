<?php
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
  call_user_func($data->FunctionName,$data->inputs);
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

//***********Functions Start here //

function Register($inputs)
{
include("members.php");
$newMember=new member;
$newMember->CreateNew( $inputs[0]);
}
function signIn($inputs)
{
include("members.php");
$newMember=new member;
$newMember->signIn($inputs[0]);
}

 ?>
