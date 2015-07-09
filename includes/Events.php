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

public function getEventbyID($inputs){

  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
    mysql_query("set names 'utf8'");
    $query = mysql_query("SELECT * FROM `Events`  WHERE `id` = \"".$inputs->Eventid."\"  ") or die (mysql_error());
    if ($query){
    $row = mysql_fetch_array($query,MYSQL_ASSOC);
    echo json_encode($row);
  }
  else{
    $respond = array('sucess' => false);
   echo json_encode($respond);
  }
  $dbConnect->close();

}

public function getEventTypebyID($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
    $query = mysql_query("SELECT eventType FROM `Events`  WHERE `id` = \"".$inputs."\"  ") or die (mysql_error());
  $re=0;
    if ($query){
    $row = mysql_fetch_array($query,MYSQL_ASSOC);
      $re= $row["eventType"];
  }
  $dbConnect->close();
return $re;
}


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
// the user can create event
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

public function getUserEventsList($inputs){
$inputs->userID;
require_once("DataBaseConnection.php");
$dbConnect=new DatabaseConnect;
  mysql_query("set names 'utf8'");
  $query = mysql_query("SELECT `id`,`VIP`,`eventType`,`subject`,`picture`,`TimeEnded`,`approved` FROM `Events` WHERE `CreatorID` = \"".$inputs->userID."\"  ORDER BY `Events`.`timeCreated` DESC   LIMIT ".$inputs->start.", ".$inputs->limit." ") or die (mysql_error());
$stack = array();
  while($row = mysql_fetch_array($query)){

    $user = array(
    'id'=>$row['id'],
    'VIP'=>$row['VIP'],
    'eventType'=>$row['eventType'],
    'subject'=>$row['subject'],
    'picture'=>$row['picture'],
    'TimeEnded'=>$row['TimeEnded'],
    'approved'=>$row['approved']
    );
  array_push($stack, $user);
}
  echo json_encode($stack);
   $dbConnect->close();
}

public function getGroupEvents($inputs){
require_once("DataBaseConnection.php");
$dbConnect=new DatabaseConnect;
  mysql_query("set names 'utf8'");

  $query = mysql_query("SELECT `Events`.`id` , `members`.`name`, `members`.`groupID` , `members`.`ProfilePic` , `Events`.`subject` , `Events`.`VIP` ,`Events`.`picture` , `Events`.`TimeEnded` , `Events`.`approved` from `Events` INNER JOIN `members` ON
   `Events`.`CreatorID`=`members`.`id` WHERE `members`.`groupID` = ".$inputs->groupID." AND `Events`.`approved`=1 ORDER BY  `Events`.`VIP` DESC, `Events`.`TimeEnded` DESC LIMIT ".$inputs->start.", ".$inputs->limit." ") or die (mysql_error());
$stack = array();
  while($row = mysql_fetch_array($query)){
    $user = array(
    'Eventid'=>$row['id'],
    'CreatorName'=>$row['name'],
    'CreatorPic'=>$row['ProfilePic'],
    'subject'=>$row['subject'],
    'EventPic'=>$row['picture'],
    'VIP'=>$row['VIP'],
    'TimeEnded'=>$row['TimeEnded']
    );
  array_push($stack, $user);
}
  echo json_encode($stack);
   $dbConnect->close();
}

public function getEvents($inputs)
{
//$inputs->groupID;// -1:home page  anyother value i am on a group
//$inputs->catID;//-1 uncatigorized , anyother value catigorized
//$inputs->start;
//$inputs->limit;
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
    mysql_query("set names 'utf8'");
$Filters="";
if($inputs->groupID==-1)
{
  $Filters.="AND `Events`.`VIP` = 1";
//Homepage
}
else{
  $Filters.="AND `members`.`groupID` = ".$inputs->groupID." ";
//Group page
}
if($inputs->catID!=-1)
{
  $Filters.=" AND `Events`.`eventType` = ".$inputs->catID." ";
//catigorized
}
    $query = mysql_query("SELECT
      `Events`.`id` ,
      `members`.`name`,
      `members`.`groupID` ,
      `members`.`ProfilePic` ,
      `Events`.`subject` ,
      `Events`.`VIP` ,
      `Events`.`picture` ,
      `Events`.`TimeEnded` ,
      `Events`.`approved`
      from `Events` INNER JOIN `members` ON   `Events`.`CreatorID`=`members`.`id`
      WHERE `Events`.`approved`=1 ".$Filters."
      ORDER BY  `Events`.`VIP` DESC,
      `Events`.`timeCreated` DESC
      LIMIT ".$inputs->start.", ".$inputs->limit." ") or die (mysql_error());
      $stack = array();

      while($row = mysql_fetch_array($query)){
      $user = array(
      'Eventid'=>$row['id'],
      'CreatorName'=>$row['name'],
      'CreatorPic'=>$row['ProfilePic'],
      'subject'=>$row['subject'],
      'EventPic'=>$row['picture'],
      'VIP'=>$row['VIP'],
      'TimeEnded'=>$row['TimeEnded']
      );
    array_push($stack, $user);
  }
    echo json_encode($stack);
     $dbConnect->close();
}





}








 ?>
