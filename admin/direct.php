<?php



require_once("../configuration.php");
require_once('../db.php');
$db = new db(DB_DATABASE, DB_USER, DB_PASSWORD, DB_HOST); // $host is optional and defaults to 'localhost'
mysql_query("set names 'utf8'");
require_once("members.php");
require_once("group.php");
require_once("events.php");
require_once("news.php");
require_once("comments.php");
require_once("feedbacks.php");
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
}else{
include ("home.php");
}








 ?>
