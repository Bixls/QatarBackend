<?php

class invitationsLog{

public function invite($inputs)
{
  require_once("DataBaseConnection.php");


  require_once("Messages.php");
  $messege=new Messages;

  $messegeInput = new stdClass();
  $messegeInput->SenderID = $inputs->SenderID;
  $messegeInput->Subject = $inputs->Subject;
  $messegeInput->Content = $inputs->Content;
  $messegeInput->EventID = $inputs->EventID;
$respond= array();

foreach ($inputs->listArray as $key) {

$dbConnect=new DatabaseConnect;
$query = mysql_query("SELECT * FROM `invitationsLog` WHERE `EventID` = \"".$inputs->EventID."\" AND
`memberID` = \"".$key->id."\" ") or die (mysql_error());
$row=mysql_fetch_array($query);
  $res = new stdClass();
  $res->id=$key->id;
    if(empty($row)){
    $sql = mysql_query("INSERT INTO `".DB_DATABASE."`.`invitationsLog` (`EventID`,`memberID`)
    VALUES ('".$inputs->EventID."', '".$key->id."');") or die (mysql_error());
    $dbConnect->close();
    $messegeInput->ReciverID=$key->id;
        if($messege->sendMessegeWithReturn($messegeInput)){
          //Messege Sent
          $res->sucess=true;
        }
        else{
            $res->sucess=false;
            //Messege was not Sent
        }
    }
    else{
      $res->sucess=false;
      //Already invited
    }
    array_push($respond,$res);
}
echo json_encode($respond);

}


public function JoinEvent($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
$query=mysql_query("UPDATE  `invitationsLog` SET `IsGoing` = '1' WHERE `invitationsLog`.`memberID` = ".$inputs->memberID." AND `invitationsLog`.`EventID`=".$inputs->eventID)or die (mysql_error());
if($query){
  $respond = array('sucess' => true);
}else{
  $respond = array('sucess' => false);
}
 echo json_encode($respond);
  $dbConnect->close();
}
public function LeaveEvent($inputs){

  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $query=mysql_query("UPDATE  `invitationsLog` SET `IsGoing` = '0' WHERE `invitationsLog`.`memberID` = ".$inputs->memberID." AND `invitationsLog`.`EventID`=".$inputs->eventID)or die (mysql_error());
  if($query){
  $respond = array('sucess' => true);
  }else{
  $respond = array('sucess' => false);
  }
  echo json_encode($respond);
  $dbConnect->close();
}
public function ViewEventAttendees($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
      mysql_query("set names 'utf8'");
$query=mysql_query("SELECT members.id , members.name , members.ProfilePic FROM invitationsLog
   INNER JOIN members ON invitationsLog.memberID=members.id WHERE i nvitationsLog.EventID=
".$inputs->eventID."  LIMIT ".$inputs->start.", ".$inputs->limit."");
$stack = array();
if($query){
while($row = mysql_fetch_array($query,MYSQL_ASSOC)){
  array_push($stack, $row);

}
}

echo json_encode($stack);
$dbConnect->close();

}
public function isJoind($inputs){
require_once("DataBaseConnection.php");
$dbConnect=new DatabaseConnect;
$query = mysql_query("SELECT `IsGoing` FROM `invitationsLog` WHERE `EventID` = \"".$inputs->eventID."\" AND
`memberID` = \"".$inputs->memberID."\" ") or die (mysql_error());
$row=mysql_fetch_array($query);
$found=false;
if($row["IsGoing"]==1){
$found=true;
}
echo json_encode($found);
$dbConnect->close();
}

public function isInvited($inputs){
  require_once("DataBaseConnection.php");
  $dbConnect=new DatabaseConnect;
  $query = mysql_query("SELECT * FROM `invitationsLog` WHERE `EventID` = \"".$inputs->eventID."\" AND
  `memberID` = \"".$inputs->memberID."\" ") or die (mysql_error());
$row=mysql_fetch_array($query);
$found=false;
if(!empty($row)){
  $found=true;
}

echo json_encode($found);
$dbConnect->close();

}









}






 ?>
