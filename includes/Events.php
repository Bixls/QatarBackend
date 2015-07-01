<?php

class Events{

public $id;
public $CreatorID;
public $VIP;
public $eventType;
public $subject;
public $description;
public $picture;
public $timeCreated;
public $TimeEnded;
public $comments;


public function CreateEvent($inputs) {
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
    mysql_query("set names 'utf8'");
    $MembersQuery = mysql_query("SELECT `inNOR` , `inVIP` FROM `members` WHERE `id` = \"".$inputs->CreatorID."\"  ") or die (mysql_error());
    $membersRow = mysql_fetch_array($MembersQuery);
    $valid=false;
if($inputs->VIP==0&&$membersRow['inNOR']>0)
{
$valid=true;
$newValue=$membersRow['inNOR']-1;
$query = mysql_query("UPDATE  `".DB_DATABASE."`.`members` SET `inNOR` =  '".$newValue."'  WHERE `id` = \"".$inputs->CreatorID."\"") or die (mysql_error());
}
elseif($inputs->VIP==1&&$membersRow['inVIP']>0)
{
$valid=true;
$newValue=$membersRow['inVIP']-1;
$query = mysql_query("UPDATE  `".DB_DATABASE."`.`members` SET `inVIP` =  '".$newValue."'  WHERE `id` = \"".$inputs->CreatorID."\"") or die (mysql_error());
}


if($valid)
{
mysql_query("set names 'utf8'");
$sql = "INSERT INTO `".DB_DATABASE."`.`Events` (`CreatorID`,`VIP`,  `eventType`, `subject`, `description`, `TimeEnded`, `comments`)
VALUES ('".$inputs->CreatorID."', '".$inputs->VIP."', '".$inputs->eventType."', '".$inputs->subject."', '".$inputs->description."', '".$inputs->TimeEnded."','".$inputs->comments."');";
mysql_query($sql);
$respond = array('sucess' => true);
echo json_encode($respond);
}else{
  $respond = array('sucess' => false);
 echo json_encode($respond);
}



$dbConnect->close();
}

}








 ?>
