<?php


require_once("members.php");


if(isset($_POST['fn']))
{
$function=$_POST['fn'];
$inputs=$_POST['i'];
$class=$_POST['c'];
call_user_func($class."::".$function,$inputs);
}
elseif(isset($_GET['fn']))
{
$function=$_GET['fn'];
$inputs=$_GET['i'];
$class=$_GET['c'];
call_user_func($class."::".$function,$inputs);
}








 ?>
