<?php
$table="members";
$per_page = 5;
$where=array("Verified!=0");
$title="Members admin panel";

$list = array('id'=>'id' ,' Name'=>'name','Picture'=>'ProfilePic','Gname'=>'Gname');
$customeFileds= array('Approve' =>"approve.php?id=" ,
                      'Delete'=>"delete.php?id=");
$innerJoin="INNER JOIN `groups` ON `members`.`groupID`=`groups`.`Gid`";
require_once("View.php");
 ?>
