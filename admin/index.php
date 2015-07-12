<?php

require_once("../configuration.php");
require_once('../db.php');
$db = new db(DB_DATABASE, DB_USER, DB_PASSWORD, DB_HOST); // $host is optional and defaults to 'localhost'
mysql_query("set names 'utf8'");
$title="Admin Panel";

include ("views/header.php");

require_once("members.php");

if(!empty($_GET))
{
$function=$_GET['fn'];
$inputs=$_GET['i'];
$class=$_GET['c'];
call_user_func($class."::".$function,$inputs);;
}


include ("views/footer.php");
?>
