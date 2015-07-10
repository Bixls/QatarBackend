<?php
$table="members";
$per_page = 5;
$where=array( );
$title="Members admin panel";

$list = array('id'=>'id' ,' Name'=>'name','Picture'=>'ProfilePic');
$customeFileds= array('Approve' =>"approve.php?id=" ,
                      'Delete'=>"delete.php?id=");

require_once("View.php");
 ?>
