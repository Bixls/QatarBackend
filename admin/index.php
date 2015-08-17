<?php
session_start();
if(isset($_SESSION["username"])||isset($_COOKIE["username"])){
  if(isset($_COOKIE["username"])){
    $_SESSION['username']=$_COOKIE["username"];
  }
require_once("../configuration.php");
require_once('../db.php');
$db = new db(DB_DATABASE, DB_USER, DB_PASSWORD, DB_HOST); // $host is optional and defaults to 'localhost'
mysql_query("set names 'utf8'");
$title="Admin Panel";

$per_page=10;

include ("views/header.php");



include_once("direct.php");


include ("views/footer.php");
}else{
include ("login.php");
}
?>
