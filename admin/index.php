<?php

require_once("../configuration.php");
require_once('../db.php');
$db = new db(DB_DATABASE, DB_USER, DB_PASSWORD, DB_HOST); // $host is optional and defaults to 'localhost'
mysql_query("set names 'utf8'");
$title="Admin Panel";



include ("views/header.php");



include_once("direct.php");


include ("views/footer.php");
?>
